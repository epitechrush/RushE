(function()
{
    var dropzone = document.getElementById("dropzone");

    dropzone.ondrop = function(e) {

        e.preventDefault.default();

    };

    dropzone.ondragover = function(){
        this.className = "dropzone dragover";
        return false;
    };
    
    dropzone.ondragleave = function (){
        this.className = "dropzone";
        return false;
    };
}());