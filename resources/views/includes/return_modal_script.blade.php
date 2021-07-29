<script>
    $(document).ready(function(){
        var myModal = new bootstrap.Modal(document.getElementById('myModal'))
        $(".modalToggle").on("click", function () {
            $("#modalLink").attr("href", $(this).attr("return_link"))
            myModal.toggle()
        })
    });
</script>