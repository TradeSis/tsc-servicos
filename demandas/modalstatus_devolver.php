   <!--------- MODAL DEVOLVER --------->
   <div class="modal" id="devolverModal" tabindex="-1" role="dialog" aria-labelledby="devolverModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-lg">
           <div class="modal-content">
               <div class="modal-header">
                   <!-- lucas 22092023 ID 358 Modificado titulo do modal-->
                   <h5 class="modal-title" id="exampleModalLabel">Devolver chamado - <?php echo $demanda['tituloDemanda'] ?></h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                   <form method="post">
                       <div class="container-fluid p-0">
                        <!-- lucas 27022024 - id853 nova chamada editor quill -->
                           <div id="ql-toolbarDevolver">
                               <?php include ROOT."/sistema/quilljs/ql-toolbar-min.php"  ?>
                               <input type="file" id="anexarDevolver" class="custom-file-upload" name="nomeAnexo" onchange="uploadFileDevolver()" style=" display:none">
                               <label for="anexarDevolver">
                                   <a class="btn p-0 ms-1"><i class="bi bi-paperclip"></i></a>
                               </label>
                           </div>
                           <div id="ql-editorDevolver" style="height:30vh !important">
                           </div>
                           <textarea style="display: none" id="quill-devolver" name="comentario"></textarea>
                       </div>
                       <div class="col-md">
                           <input type="hidden" class="form-control" name="idDemanda" value="<?php echo $demanda['idDemanda'] ?>" readonly>
                           <input type="hidden" class="form-control" name="idCliente" value="<?php echo $demanda['idCliente'] ?>" readonly>
                           <input type="hidden" class="form-control" name="idUsuario" value="<?php echo $usuario['idUsuario'] ?>" readonly>
                           <input type="hidden" class="form-control" name="tipoStatusDemanda" value="<?php echo $demanda['idTipoStatus'] ?>" readonly>
                           <input type="hidden" class="form-control" name="origem" value="<?php echo $origem ?>" readonly>
                           <?php if (isset($url_idTipoContrato[2])) { ?>
                                <input type="hidden" class="form-control" name="idTipoContrato" value="<?php echo $url_idTipoContrato[2] ?>" readonly>
                            <?php } ?>
                       </div>
               </div>
               <div class="modal-footer">
                    <?php if ($_SESSION['administradora'] == 1) { ?>
                        <div class="mt-2 form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="interno" id="interno" value="1">
                            <label class="form-check-label" for="interno">Interno</label>
                        </div>
                    <?php } ?>
                   <!-- lucas 22092023 ID 358 Modificado nome do botao-->
                   <button type="submit" formaction="../database/demanda.php?operacao=atualizar&acao=devolver" class="btn btn-warning">Devolver</button>
               </div>
               </form>
           </div>
       </div>
   </div>

    <!-- lucas 27022024 - id853 nova chamada editor quill -->
    <!-- gabriel 27052024 - id981 removido modalstatus.js para evitar redundancia do script -->
    <script>
    var quillDevolver = new Quill('#ql-editorDevolver', {
        modules: {
            toolbar: '#ql-toolbarDevolver'
        },
        placeholder: 'Digite o texto...',
        theme: 'snow'
    });

    quillDevolver.on('text-change', function (delta, oldDelta, source) {
        $('#quill-devolver').val(quillDevolver.container.firstChild.innerHTML);
    });

    async function uploadFileDevolver() {

        let endereco = '/tmp/';
        let formData = new FormData();
        var custombutton = document.getElementById("anexarDevolver");
        var arquivo = custombutton.files[0]["name"];

        formData.append("arquivo", custombutton.files[0]);
        formData.append("endereco", endereco);

        destino = endereco + arquivo;

        await fetch('/sistema/quilljs/quill-uploadFile.php', {
            method: "POST",
            body: formData
        });

        const range = this.quillDevolver.getSelection(true)

        this.quillDevolver.insertText(range.index, arquivo, 'user');
        this.quillDevolver.setSelection(range.index, arquivo.length);
        this.quillDevolver.theme.tooltip.edit('link', destino);
        this.quillDevolver.theme.tooltip.save();

        this.quillDevolver.setSelection(range.index + destino.length);

    }
    </script>