<?php
if(count(get_included_files()) ==1) exit('Acesso direto não permitido');
?>
<!DOCTYPE html>

<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/ico.png" />
    <title>Editor do Assinador de PDF</title>
    <link rel="stylesheet" href="assets/tools/bootstrap-4.4.1.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/tools/prettify-r298.min.css" />
    <link rel="stylesheet" href="assets/editor.css" />
    <link rel="stylesheet" href="assets/tools/pdfannotate.css" />
</head>

<body>
    <!--div class="toolbar">
      <div class="tool">
        <span>PDF Editor</span>
      </div-->
    <!--div class="tool">
		<label for="">Brush size</label>
		<input type="number" class="form-control text-right" value="1" id="brush-size" max="50">
	</div>
	<div class="tool">
		<label for="">Font size</label>
		<select id="font-size" class="form-control">
			<option value="10">10</option>
			<option value="12">12</option>
			<option value="16" selected>16</option>
			<option value="18">18</option>
			<option value="24">24</option>
			<option value="32">32</option>
			<option value="48">48</option>
			<option value="64">64</option>
			<option value="72">72</option>
			<option value="108">108</option>
		</select>
	</div>
	<div class="tool">
		<button class="color-tool active" style="background-color: #212121;"></button>
		<button class="color-tool" style="background-color: red;"></button>
		<button class="color-tool" style="background-color: blue;"></button>
		<button class="color-tool" style="background-color: green;"></button>
		<button class="color-tool" style="background-color: yellow;"></button>
	</div-->
    <!--div class="tool">
        <button class="tool-button active">
          <i
            class="fas fa-hand-paper"
            title="Free Hand"
            onclick="enableSelector(event)"
          ></i>
        </button>
      </div-->
    <!--div class="tool">
		<button class="tool-button"><i class="fas fa-pencil" title="Pencil" onclick="enablePencil(event)"></i></button>
	</div-->
    <!--div class="tool">
        <button class="tool-button">
          <i
            class="fas fa-font"
            title="Add Text"
            onclick="enableAddText(event)"
          ></i>
        </button>
      </div>
      <div class="tool">
		<button class="tool-button"><i class="fas fa-long-arrow-right" title="Add Arrow" onclick="enableAddArrow(event)"></i></button>
</div>
	<div class="tool">
		<button class="tool-button"><i class="fas fa-square" title="Add rectangle" onclick="enableRectangle(event)"></i></button>
	</div>
      <-div class="tool">
        <button class="tool-button">
          <i
            class="fa fa-image"
            title="Add an Image"
            onclick="addImage(event)"
          ></i>
        </button>
      </div-->
    <!--div class="tool">
        <button class="tool-button">
          <i
            class="fas fa-file-signature"
            title="Adicionar Assinatura"
            onclick="enableImageCheck(event)"
          ></i>
        </button>
      </div-->
    <!--div class="tool">
		    <button class="tool-button" id="modalBtnSign"><i class="fas fa-signature" title="Add an Sign" onclick="showSignModal()"></i></button>
	    </div-->
    <!--div class="tool">
        <button
          class="btn btn-danger btn-sm"
          onclick="deleteSelectedObject(event)"
        >
          <i class="fa fa-trash"></i>
        </button>
      </div-->
    <!--div class="tool">
        <p id="ar-pyh">Insira a assinatura para obter informações dos comandos do pyhanko.</p>
      </div-->
    <!--div class="tool">
        <form
          method="POST"
          enctype="multipart/form-data"
          action="pyhanko.php"
        >
          <input type="hidden" name="p12" id="p12-inp" value="<?=$status['p12']['filename']?>" />
          <input type="hidden" name="pdf" id="pdf-inp" value="<?=$status['pdf']['filename']?>" />
          <input type="hidden" name="coordenadas" id="coordenadas"/>
        </form>
      </div-->
    <!--div class="tool">
		<button class="btn btn-danger btn-sm" onclick="clearPage()">Clear Page</button>
	</div>
	<div class="tool">
		<button class="btn btn-info btn-sm" onclick="showPdfData()">{}</button>
	</div-->

    <!--div class="tool">
        <button class="btn btn-light btn-sm" onclick="savePDF()">
          <i class="fa fa-save"></i> Save
        </button>
      </div>
    </div-->
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <span class="navbar-brand mb-0">Editor de PDF</span>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <div class="tool">
                    <a class="nav-item nav-link active tool-button" href="#" onclick="enableSelector(event)">
                        <i class="fas fa-hand-paper fa-lg" title="Free Hand"></i>
                    </a>
                </div>
                <div class="tool">
                    <a class="nav-item nav-link tool-button" href="#">
                        <i class="fas fa-file-signature fa-lg" title="Adicionar Assinatura"
                            onclick="enableImageCheck(event)"></i>
                    </a>
                </div>
                <div class="tool">
                    <a class="nav-item nav-link tool-button" href="#" onclick="deleteSelectedObject(event)">
                        <i class="fa fa-trash text-danger fa-lg"></i>
                    </a>
                </div>
            </div>
        </div>
        <form class="form-inline" id="form-data" method="POST" action="php/pyhanko.php">
            <input type="hidden" name="pdf" id="pdf-inp" value="<?=$status['pdf']['filename']?>" />
            <input type="hidden" name="coordenadas" id="coordenadas" />
            <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-outline-light fa-solid fa-code" onclick="showCode(event)">
                    Code</button>
                <button type="button" class="btn btn-outline-light fa-solid fa-download" onclick="signPdf(event)">
                    Download</button>
            </div>
        </form>
    </nav>


    <div id="pdf-container"></div>
    <!-- JSON File -->
    <!-- 
<div class="modal fade" id="dataModal" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="dataModalLabel">PDF annotation data</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<pre class="prettyprint lang-json linenums">
				</pre>
			</div>
		</div>
	</div>
</div> -->

    <!-- Signature Modal -->
    <div class="modal fade" id="dataModalSign" tabindex="-1" role="dialog" aria-labelledby="dataSignature"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dataSignature">Signature</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="signature-wrapper">
                        <canvas id="signature-pad" class="signature-pad" width="500" height="200"
                            style="max-width: 500px"></canvas>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="save-png" data-dismiss="modal" aria-label="Close">
                        Add
                    </button>
                    <button id="clear">Clear</button>
                </div>
            </div>
        </div>
    </div>
    <div class="tool">
        <img src="assets/img/assinatura.png" alt="Assinatura" class="nkar" hidden ar-ativo="0" />
    </div>
    <!-- Signature Script -->
    <script src="assets/tools/signature_pad.umd.js"></script>
    <script src="assets/tools/jquery-3.5.1.min.js"></script>
    <script src="assets/tools/popper-1.16.1.min.js"></script>
    <script src="assets/tools/bootstrap-4.5.2.min.js"></script>
    <script src="assets/tools/pdf-2.6.347.min.js"></script>
    <script>
    pdfjsLib.GlobalWorkerOptions.workerSrc =
        "assets/tools/pdf.worker-2.6.347.min.js";
    </script>
    <script src="assets/tools/fabric-4.3.0.min.js"></script>
    <script src="assets/tools/jspdf.umd-2.2.0.min.js"></script>
    <script src="assets/tools/run_prettify.js"></script>
    <script src="assets/tools/prettify-r298.min.js"></script>
    <script src="assets/tools/arrow.fabric.js"></script>
    <script src="assets/tools/sweetalert.min.js"></script>
    <script src="assets/pdfannotate.js"></script>
    <script src="assets/editor.js"></script>
</body>

</html>