<html>
 <head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laravel 5.8 - Multiple File Upload with Progressbar using Ajax jQuery</title>
  {{-- CSS assets in head section --}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />

{{-- ... a lot of main HTML code ... --}}

{{-- JS assets at the bottom --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.js"></script>
{{-- ...Some more scripts... --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
 </head>
 <body>
    <form action="{{ route("projects.store") }}" method="POST" enctype="multipart/form-data">
        @csrf
    
        {{-- Name/Description fields, irrelevant for this article --}}
    
        <div class="form-group">
            <label for="document">Documents</label>
            <div class="needsclick dropzone" id="document-dropzone">
    
            </div>
        </div>
        <div>
            <input class="btn btn-danger" type="submit">
        </div>
    </form>


    <script>
        var uploadedDocumentMap = {}
        Dropzone.options.documentDropzone = {
          url: '{{ route('projects.storeMedia') }}',
          paramName: "file",
          uploadMultiple: true,
          maxFilesize: 16, // MB
          acceptedFiles: '.jpg, .png, .gif, .jpeg',
          addRemoveLinks: true,
          dictRemoveFile: 'Xoá ảnh',
          dictFileTooBig: 'Image is larger than 16MB',
          headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
          },
          success: function (file, response) {
            $('form').append('<input type="hidden" name="document[]" value="' + response.name + '">')
            uploadedDocumentMap[file.name] = response.name
          },
          removedfile: function(file) 
            {
                var name = file.upload.filename;
                $.ajax({
                    headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            },
                    type: 'POST',
                    url: '{{ route('projects.deletefile') }}',
                    data: {filename: name},
                    success: function (data){
                        console.log("File deleted successfully!!");
                    },
                    error: function(e) {
                        console.log(e);
                    }});
                    var fileRef;
                    return (fileRef = file.previewElement) != null ? 
                    fileRef.parentNode.removeChild(file.previewElement) : void 0;
            },
            success: function(file, response) 
            {
                console.log(response);
            },
            error: function(file, response)
            {
               return false;
            },
          init: function () {
            @if(isset($project) && $project->document)
              var files =
                {!! json_encode($project->document) !!}
              for (var i in files) {
                var file = files[i]
                this.options.addedfile.call(this, file)
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="document[]" value="' + file.file_name + '">')
              }
            @endif
          }
        }
      </script>
 </body>
</html>

