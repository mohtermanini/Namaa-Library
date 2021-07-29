<script>
    var myModal = new bootstrap.Modal(document.getElementById('myModal'))
    $(".modalToggle").on("click", function () {
        $("#modalForm").attr("action", $(this).attr("delete_link"))
        myModal.toggle()
    })
</script>