 
  <!-- Modal -->
  <div wire:ignore.self data-bs-backdrop="static" class="modal fade" id="modalCapturePicture" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4>CAPTURAR COMPROVATIVO</h4>
        </div>
        <div class="modal-body">

     
          <div id="my_camera"></div>
	        <div id="my_result" class="mt-1"></div>
           <div class="container">
            <div class="row">
              <video width= "340px" height="260px" autoplay></video>
              <canvas></canvas>
            </div>
          </div>
          <div class="col-md-12 d-flex justify-content-center flex-wrap align-items-center">
            <div class="btn-group" role="group" aria-label="Basic example">
              <button id="capturePicture" class=" col-md-4 btn btn-md btn-primary-welcome-client mt-3">
                CAPTURAR
              </button>
              <button class="closecamera btn btn-danger col-md-4 btn btn-md mt-3"><i class="fa fa-times"></i> 
                FECHAR
              </button>
            </button>
            </div> 

            <div class="container">
              <div class="row addLink text-center text-primary fw-bold mt-3">
                  <a href="" download class="d-none" id="download">DOWNLOAD DO COMPROVATIVO</a>
              </div>
            </div>
        </div>
      </div>
    </div>
    
  </div>
 