<div class="data-container">
    <form action="/document/create" method="post" enctype="multipart/form-data" style="width: 100%; max-width: 400px;">
        <div class="form-card">
            <div class="form-group">
                <label for="inscripcion">Inscripción (PDF)</label>
                <input type="file" name="inscripcion" id="inscripcion" accept="application/pdf">
                <a href="#" id="ver-inscripcion" target="_blank" style="display:none; margin-left:10px;">Ver</a>
            </div>
        </div>
        <div class="form-card">
            <div class="form-group">
                <label for="certificado">Certificado (PDF)</label>
                <input type="file" name="certificado" id="certificado" accept="application/pdf">
                <a href="#" id="ver-certificado" target="_blank" style="display:none; margin-left:10px;">Ver</a>
            </div>
        </div>
        <div class="form-card">
            <div class="form-group">
                <label for="preparticipacion">Preparticipación (PDF)</label>
                <input type="file" name="preparticipacion" id="preparticipacion" accept="application/pdf">
                <a href="#" id="ver-preparticipacion" target="_blank" style="display:none; margin-left:10px;">Ver</a>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Subir Documentos</button>
    </form>
</div>
<!-- Modal para previsualizar PDF -->
<div id="pdf-modal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.7); align-items:center; justify-content:center; z-index:9999;">
    <div style="background:#fff; padding:1rem; border-radius:8px; max-width:90vw; max-height:90vh; position:relative; display:flex; flex-direction:column; align-items:center;">
        <button onclick="closePdfModal()" style="position:absolute; top:10px; right:10px; background:#ff5252; color:#fff; border:none; border-radius:4px; padding:0.5rem 1rem; cursor:pointer;">Cerrar</button>
        <iframe id="pdf-frame" src="" style="width:70vw; height:80vh; border:none;"></iframe>
    </div>
</div>
<script>
function openPdfModal(url) {
    document.getElementById('pdf-frame').src = url;
    document.getElementById('pdf-modal').style.display = 'flex';
}
function closePdfModal() {
    document.getElementById('pdf-modal').style.display = 'none';
    document.getElementById('pdf-frame').src = '';
}

function addPreview(inputId, linkId) {
    const input = document.getElementById(inputId);
    const link = document.getElementById(linkId);
    input.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file && file.type === "application/pdf") {
            const url = URL.createObjectURL(file);
            link.href = "#";
            link.style.display = 'inline';
            link.onclick = function(ev) {
                ev.preventDefault();
                openPdfModal(url);
            }
        } else {
            link.style.display = 'none';
            link.href = '#';
        }
    });
}
addPreview('inscripcion', 'ver-inscripcion');
addPreview('certificado', 'ver-certificado');
addPreview('preparticipacion', 'ver-preparticipacion');
</script>