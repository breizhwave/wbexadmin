# webxadmin PHP RAD TOOL for database administration

[//]: # ([![Build Status]&#40;https://travis-ci.org/laravel/lumen-framework.svg&#41;]&#40;https://travis-ci.org/laravel/lumen-framework&#41;)

[//]: # ([![Total Downloads]&#40;https://img.shields.io/packagist/dt/laravel/framework&#41;]&#40;https://packagist.org/packages/laravel/lumen-framework&#41;)

[//]: # ([![Latest Stable Version]&#40;https://img.shields.io/packagist/v/laravel/framework&#41;]&#40;https://packagist.org/packages/laravel/lumen-framework&#41;)

[//]: # ([![License]&#40;https://img.shields.io/packagist/l/laravel/framework&#41;]&#40;https://packagist.org/packages/laravel/lumen-framework&#41;)

Based on Lumen Framework, webxadmin is a xml based BREAD (browse, read, edit, add, delete) or CRUD ( Create-Read-Update-Delete) for MYSQL database table administration.

Declare your tables in storage / database.xml based on database.dtd 

and the controller does the BREAD / CRUD scaffolding :

* basic data table with filtering
* modal form generation with field types : input, wysiwyg (based on summer note), select (based on table relation ship)


## Installation

* clone the repository
* configure database access in .env
* create your tables in  storage / database.xml

## Basic Example

this example creates a basic time tracking application with three tables
 * Notes
   * tab based form (2 tabs defined by d_tab )
   * aggregate sum function for counting hours
   * hierachic filtering for categories and customer related tables
 * Category  / Customer : hierarchic tree structure
 * color coding for categories

```
  <d_table name="note">
        <d_tabs>
            <d_tab title="Infos"></d_tab>
            <d_tab title="Taxonomy"></d_tab>

        </d_tabs>
        <d_aggregate name="hours" function="sum"></d_aggregate>
        <d_field name="date_creation"  subtype="date" order="desc"  tab="Taxonomy"></d_field>
        <d_field name="date_modif" hide="both" subtype="date" ></d_field>
        <d_field name="title" tooltip="body"  tab="Infos"></d_field>
        <d_field name="body" type="textarea" hide="list"  tab="Infos"></d_field>
        <d_field name="category" type="select" relation="category"  tab="Taxonomy"></d_field>
        <d_field name="customer" type="select" relation="customer"  tab="Taxonomy" subtype="tree"></d_field>
        <d_field name="hours" type="number"   tab="Infos" ></d_field>
    </d_table>
       <d_table name="category">
        <d_field name="title"></d_field>
        <d_field name="body" type="textarea"></d_field>
        <d_field name="color" subtype="color"></d_field>
    </d_table>
    <d_table name="customer">
        <d_field name="parent_id" type="select" relation="customer"  ></d_field>

        <d_field name="title"></d_field>
        <d_field name="body" type="textarea"></d_field>
    </d_table>
```
## TODO

* pagination
* export
* tree field  : multi level filtering (currently only two levels)
* doc : add image in readme

## Screenshot

![Time tracking app](https://raw.githubusercontent.com/breizhwave/webxadmin/master/public/ijss/i/screenshot1-timetracking.jpg)

## Credit

* Bootstrap interface : [tabler.io](https://github.com/tabler/tabler) 
* Date Range Filter: [Date Range Picker](https://www.daterangepicker.com/)
* [Colorpicker](https://github.com/mdbassit/Coloris) 
* Wysiwyg editor : [SummerNote](https://summernote.org/)
* Hierarchical Tree filter : [select2Tree](https://github.com/clivezhg/select2-to-tree) , depends on [select2](https://github.com/select2/select2)

## Alternatives

* Laravel Nova and BackPack Manager
* https://github.com/nafiesl/SimpleCrudGenerator

## License

The webxadmin framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
