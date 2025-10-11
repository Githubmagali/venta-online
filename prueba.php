<input type="file" id="inputImagenes" name="imagenes[]" multiple accept="image/*">
<input type="number" min="1" id="cantidadPost" value="0" class="form-control text-center">

<div id="preview" class="preview-container"></div>

<script>
const inputImagenes = document.getElementById('inputImagenes');
const cantidadInput = document.getElementById('cantidadPost');
const preview = document.getElementById('preview');

// Cuando el usuario selecciona archivos
inputImagenes.addEventListener('change', (event) => {
    const archivos = event.target.files;
    cantidadInput.value = archivos.length; // Actualiza el input numérico
    preview.innerHTML = ''; // Limpia el contenedor

    // Mostrar una vista previa de cada imagen
    Array.from(archivos).forEach(file => {
        const reader = new FileReader();
        reader.onload = (e) => {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.classList.add('miniatura');
            preview.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
});

// Intersection Observer: detecta cuándo las imágenes cargadas aparecen en pantalla
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            console.log(`Imagen visible:`, entry.target.src);
            entry.target.classList.add('visible');
        }
    });
}, {
    threshold: 0.5
});

// Observar cuando se agreguen nuevas imágenes al DOM
const observerDOM = new MutationObserver(() => {
    const imagenes = document.querySelectorAll('.miniatura');
    imagenes.forEach(img => observer.observe(img));
});
observerDOM.observe(preview, {
    childList: true
});
</script>

<style>
.preview-container {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.miniatura {
    width: 100px;
    height: 100px;
    object-fit: cover;
    opacity: 0.3;
    transition: opacity 0.4s ease;
}

.miniatura.visible {
    opacity: 1;
}
</style>