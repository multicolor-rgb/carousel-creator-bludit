<link
  rel="stylesheet"
  href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css"
  type="text/css"
/>

<script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>
<script>
  // Note that the name "myDropzone" is the camelized
  // id of the form.
  Dropzone.options.myDropzone = {
    // Configuration options go here
  };
</script>

<form action="/img" class="dropzone" method="post" id="my-dropzone">
    <input type="file">
    <input type="submit" value="Test">
</form>

