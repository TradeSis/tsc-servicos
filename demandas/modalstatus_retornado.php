   <!--------- MODAL DEVOLVER --------->
   <div class="modal" id="retornadoModal" tabindex="-1" role="dialog" aria-labelledby="retornadoModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-lg">
           <div class="modal-content">
               <div class="modal-header">
                   <!-- lucas 22092023 ID 358 Modificado titulo do modal-->
                   <h5 class="modal-title" id="exampleModalLabel">Retornar chamado - <?php echo $demanda['tituloDemanda'] ?></h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                   <form method="post">
                       <div class="container-fluid p-0">
                        <!-- lucas 27022024 - id853 nova chamada editor quill -->
                           <div id="ql-toolbarRetornado">
                               <?php include ROOT."/sistema/quilljs/ql-toolbar-min.php"  ?>
                               <input type="file" id="anexarRetornado" class="custom-file-upload" name="nomeAnexo" onchange="uploadFileRetornado()" style=" display:none">
                               <label for="anexarRetornado">
                                   <a class="btn p-0 ms-1"><i class="bi bi-paperclip"></i></a>
                               </label>
                           </div>
                           <div id="ql-editorRetornado" style="height:30vh !important">
                           </div>
                           <textarea style="display: none" id="quill-retornado" name="comentario"></textarea>
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
                            <input class="form-check-input" type="checkbox" name="interno" id="interno" value="1" checked>
                            <label class="form-check-label" for="interno">Interno</label>
                        </div>
                    <?php } ?>
                   <!-- lucas 22092023 ID 358 Modificado nome do botao-->
                   <button type="submit" formaction="../database/demanda.php?operacao=atualizar&acao=retornado" class="btn btn-warning">Retornar</button>
               </div>
               </form>
           </div>
       </div>
   </div>

    <!-- lucas 27022024 - id853 nova chamada editor quill -->
    <!-- gabriel 27052024 - id981 removido modalstatus.js para evitar redundancia do script -->
    <script>
    var quillRetornado = new Quill('#ql-editorRetornado', {
        modules: {
            toolbar: '#ql-toolbarRetornado'
        },
        placeholder: 'Digite o texto...',
        theme: 'snow'
    });

    quillRetornado.on('text-change', function (delta, oldDelta, source) {
        $('#quill-retornado').val(quillRetornado.container.firstChild.innerHTML);
    });

    async function uploadFileRetornado() {

        let endereco = '/tmp/';
        let formData = new FormData();
        var custombutton = document.getElementById("anexarRetornado");
        var arquivo = custombutton.files[0]["name"];

        formData.append("arquivo", custombutton.files[0]);
        formData.append("endereco", endereco);

        destino = endereco + arquivo;

        await fetch('/sistema/quilljs/quill-uploadFile.php', {
            method: "POST",
            body: formData
        });

        const range = this.quillRetornado.getSelection(true)

        this.quillRetornado.insertText(range.index, arquivo, 'user');
        this.quillRetornado.setSelection(range.index, arquivo.length);
        this.quillRetornado.theme.tooltip.edit('link', destino);
        this.quillRetornado.theme.tooltip.save();

        this.quillRetornado.setSelection(range.index + destino.length);

    }
    </script>