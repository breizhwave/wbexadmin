
class WaveJsModal {

    /**
     *
     * @param {string} title
     * @param {string} description content of modal body
     * @param {string} yesBtnLabel label of Yes button
     * @param {string} noBtnLabel label of No button
     * @param {function} callback callback function when click Yes button
     */
    constructor( ) {
        this.modalWrap = null;
    }
    showModal(title, description, yesBtnLabel = 'Yes', SaveBtnLabel = 'Save and close', SaveContinueBtnLabel = 'Save and Continue', callback)
    {
        if (this.modalWrap !== null) {
            this.modalWrap.remove();
        }

        this.modalWrap = document.createElement('div');

        var ThirdButton="";
        if (SaveContinueBtnLabel)
            ThirdButton=`          <button type="button" class="btn btn-success btn-save-continue"  id="btnModalSaveAndContinueEdit" >${SaveContinueBtnLabel}<span class="animated-dots spinner d-none"></span></button>
`;
        this.modalWrap.innerHTML = `
    <div id="waveModal" class="modal fade" tabindex="-1">
      <div class="modal-dialog modal-full-width">
        <div class="modal-content">
          <div class="modal-header bg-dark">
            <h5 class="modal-title">${title}</h5>


          </div>
          <div class="modal-body">
            <p>${description}</p>
          </div>
          <div class="modal-footer bg-light"><div class="spinner-border spinner text-dark d-none" role="status"><span class="sr-only">  </span></div>
            <button type="button" class="btn btn-warning   btnCancel" data-bs-dismiss="modal"  >${yesBtnLabel}</button>
            ${ThirdButton}
            <button type="button" class="btn btn-success"  id="btnModalOk" >${SaveBtnLabel}<span class="animated-dots spinner d-none"></span></button>
 </div>
        </div>
      </div>
    </div>
  `;

        //this.modalWrap.querySelector('.modal-success-btn').onclick = callback;

        document.body.append(this.modalWrap);

        var modal = new bootstrap.Modal(this.modalWrap.querySelector('.modal'));
        modal.show();


    }

}
