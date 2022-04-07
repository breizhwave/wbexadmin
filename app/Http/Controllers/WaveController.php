<?php

namespace App\Http\Controllers;

    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Http\Request;
    use Illuminate\Database\QueryException;

class WaveController extends Controller
{
    /**
     * Show a list of all of the application's users.
     *
     * @return \Illuminate\Http\Response
     */
    var $tablename="note";
    public function list( Request $request,$table="")
    {
        $this->waveXML($table);
        $arrQueryParms= $request->input('formData')  ;
//        print_r($arrQueryParms);
try{
        if (!array_key_exists("order",$arrQueryParms))
        {
            $field=$this->xml->xpath("/d_schema/d_table[@name='" . $table ."']/d_field[@order]");
            if(!$field)             $field=$this->xml->xpath("/d_schema/d_table[@name='" . $table ."']/d_field");

            $arrQueryParms["order"] = $table . "." . $field[0]["name"];
             $arrQueryParms["orderDir"] =   $field[0]["order"];
            if ( $arrQueryParms["orderDir"] =="")  $arrQueryParms["orderDir"] ="asc";

        }
        else $arrQueryParms["order"]=$table . "." .  $arrQueryParms["order"];

        $recordsQuery = DB::table($this->tablename )->orderBy($arrQueryParms["order"],$arrQueryParms["orderDir"]);
        $recordsQuery->select(DB::raw(join(" ,  ", $this->arrSelectFields)));
        foreach( $this->arrLeftJoins as $k=>$arrLeftJoin)
        $recordsQuery->leftJoin($arrLeftJoin['rtable'] . " as " . $k, $arrLeftJoin['rtableid'] , '=', $arrLeftJoin['tableid'] );

        if (array_key_exists("filter",$arrQueryParms ))
        foreach($arrQueryParms["filter"] as $k=>$v)
        {

           if ($v["value"]) {
                $fieldName=strval($v["name"]);
               if ($this->arrFields[$fieldName]["subtype"]=="date")
               {
                    $arrRange=explode("-", $v["value"]);
                    $arrdate1= explode("/",$arrRange[0]);
                    $strdate1 = trim($arrdate1[2]) . "-" . trim($arrdate1[0] ). "-" . trim($arrdate1[1]);
                    $arrdate2= explode("/",$arrRange[1]);
                    $strdate2 = trim($arrdate2[2]) . "-" . trim( $arrdate2[0]) . "-" . trim($arrdate2[1]);
                   $recordsQuery->where($table .".".$v["name"], ">=",$strdate1 . " 00:00:00");
                   $recordsQuery->where($table .".".$v["name"], "<=", $strdate2 . " 23:59:59");
                //   echo $strdate1;
                }
               elseif  ($this->arrFields[$fieldName]["subtype"]=="tree")
               {
                   $field=$this->arrFields[$fieldName];
                 //  print_r($field);
                   $treeQuery = DB::table($field["relation"])->where("parent_id", $v["value"]);
                   $treeRecords=$treeQuery->get();
                   $arrSub=array( $v["value"]);
                   foreach($treeRecords as $treeRecord) $arrSub[]= $treeRecord->id;
                    //print_r(join(",",$arrSub));
                   $recordsQuery->whereIn($table . "." . $v["name"],  $arrSub);


               }
                   else {
                      if( $this->arrFields[$fieldName]["type"]=="input" ||
                      $this->arrFields[$fieldName]["type"]=="textarea" ) {
                          $recordsQuery->where($table . "." . $v["name"], 'like', '%' . $v["value"] . '%');
                          if (isset($this->arrFields[$fieldName] ["tooltip"])) $recordsQuery->orWhere($table . "." . $this->arrFields[$fieldName] ["tooltip"], 'like', '%' . $v["value"] . '%');
                      }
                      else
                          $recordsQuery->where($table . "." . $v["name"],  $v["value"]);

                   }
           }
        }

        $records=$recordsQuery->get();

    DB::enableQueryLog();

        //aggregates
    $aggregatesRecords=null;
    if( count($this->xmlTable->d_aggregate )) {
        $aggregatesQuery = $recordsQuery;
        $arrAggregatesColumn=array();
        foreach ($this->xmlTable->d_aggregate as $aggregate) {
            $fieldAlias = $aggregate["function"] . "_" . $table . "_" . $aggregate['name'];
            $arrAggregatesColumn[]=$aggregate["function"] . '(' . $table . '.' . $aggregate['name'] . ') as ' . $fieldAlias;
        }
        $aggregatesQuery->select(DB::raw(join (",", $arrAggregatesColumn)));
       $aggregatesRecords= $aggregatesQuery->get();


       //dd($recordsQuery->toSql());
     // echo "<br>";   print_r($aggregatesQuery->toSql());
    }
    echo view(

        'note.parts.list',
        [
            "arrFields"=>$this->arrFields,
            "xmlTable"=>$this->xmlTable,
            'arrQueryParms'=>$arrQueryParms,
            'records' => $records,
            'aggregatesRecords'=>$aggregatesRecords
        ]);

    } catch (QueryException $e) {
//    if ($e->getCode()=="42S22") {
//        $arrMessage=$e->getMessage() . " " . $e->getTraceAsString();
//
//        $response = "Manque une colonne : " .$arrMessage ; //$e->getSql();
//        }
//    else
        $response=$e->getCode() ."\n". $e->getMessage();
return response()->json($response, 500);
}


    }
    public function get( Request $request,$table ,$id)
    {
        $this->waveXML($table);

        $record = DB::table($this->tablename )->where("id",$id)->first() ;
        return json_encode($record );
    }

    private function waveXML($table)
    {
        $this->tablename=$table;
        $options = LIBXML_DTDATTR | LIBXML_DTDLOAD | LIBXML_NOENT | LIBXML_DTDVALID | LIBXML_NOCDATA;
        $this->xml = simplexml_load_file(storage_path('app') . '/database.xml',null,$options);


        $this->arrFields=array(); //array tio store complex data, "It is not yet possible to assign complex types to attributes
        $this->arrSelectFields=array( $table. ".id"  );
        $this->arrLeftJoins=array();

        foreach($this->xml->d_table as $k=>$xmlKtable) {

            $this->setElementTitle($xmlKtable);
            if ($table == $xmlKtable["name"]) //attribute
            {
                $this->xmlTable = $xmlKtable;
                    foreach($xmlKtable->d_field  as $kk=>$field) {
    //                 $this->arrFields[strval($field['name'])]=array();
                        $this->setElementTitle($field);
                        $fieldName=strval($field['name']);
                        $this->arrFields[$fieldName]["type"]=$field["type"];
                        $this->arrFields[$fieldName]["relation"]=$field["relation"];
                        $this->arrFields[$fieldName]["subtype"]=$field["subtype"];
                        $this->arrFields[$fieldName]["tooltip"]=$field["tooltip"];
                        if ($field["type"] == "select") {
                            $rtable = $field["relation"];
                            $rtablealias = "table_" . $fieldName;


                            $this->arrSelectFields[] = $rtablealias . ".title as " . $rtable . "_title";

                            $xmlRtableColorField = $this->xml->xpath("/d_schema/d_table[@name='" . $rtable ."']/d_field[@subtype='color']");
                            if($xmlRtableColorField)
                            {
                                $this->arrFields[$fieldName]["subtype"]="rColor";
                                $colorFieldName=$xmlRtableColorField[0]["name"];
                                $this->arrSelectFields[] = $rtablealias . "."  . $colorFieldName . " as " . $rtable . "_" . $colorFieldName;

                            }


                            $this->arrFields[$fieldName]["rTableRecords"] = DB::table($rtable)->get();
                           // $this->arrFields[$fieldName]["subtype"] = DB::table($rtable)->get();
                            $this->arrLeftJoins[] = array(
                                'rtable' => $rtable . " as  $rtablealias",
                                'rtableid' => $rtablealias . '.' . 'id',
                                'tableid' => $table . '.' . $field["name"]

                            );
                        }
                        if ($field["subtype"] == "date")
                        $this->arrSelectFields[] = "date_format(" . $table . "." . $field["name"] . ",'%d/%m/%Y' ) as " . $table . "_" . $field["name"] ;
                        else
                            $this->arrSelectFields[] = $table . "." . $field["name"] . " as " . $table . "_" . $field["name"] ;
                }
            }

        }
    }
    public function index( Request $request,$table="")
    {
        $this->waveXML($table);

        echo view(

            'note.index',
                [
                    "requestAll"=>$request->all(),
                    "xml"=>$this->xml,
                    "arrFields"=>$this->arrFields,
                    "xmlTable"=>$this->xmlTable,
                    'title' =>  $this->xmlTable["title"] ]);
        }
        private function setElementTitle(&$element)
    {
        if (!isset($element["title"]))
            $element["title"]=ucfirst($element["name"]);
}
        public function save(Request $request,$table, $id="")
        {
            $this->tablename=$table;

            parse_str(  $request->input('formData'), $arrGravityPost) ;

            foreach ($arrGravityPost as $k=>$v)
            if ($v=="") $arrGravityPost[$k]=null;

            try {
                if ($id=="")
                    $id = DB::table( $this->tablename )->insertGetId($arrGravityPost);
                else
                    DB::table( $this->tablename )->where("id",$id)->update($arrGravityPost);
                return $id;

            } catch (QueryException $e) {
                 return response()->json($e->getMessage(), 500);
            }


        }
    public function delete(Request $request,$table, $id="")
    {
        $this->tablename=$table;

        try {
            if ($id!="")
                $id = DB::table( $this->tablename )->delete($id);
            return "delete" .$id;
        } catch (QueryException $e) {
            return response()->json($e->getMessage(), 500);
        }

    }


}
