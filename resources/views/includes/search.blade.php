<script type="text/javascript">
$(document).ready(function() {
    var xhr = null;
    const field = document.getElementById('searchBox');
    const ac = new Autocomplete(field, {
        data: [],
        maximumItems: {{Config::get("max_search_items")}},
        treshold: 1,
        onInput: function () {
            document.getElementById('search_value').value = -1
            var options = {};
            options.url = "{{ $search_url }}";
            options.type = "POST";
            options.data = {
                "name": $("#searchBox").val(),
                "_token": "{{ csrf_token() }}"
            };
            options.dataType = "json";
            options.success = function (data) {
                ac.setData(data);
                ac.renderIfNeeded()
            };
            if(xhr !== null){
                xhr.abort();
            }
            xhr = $.ajax(options);
        },
        onSelectItem: ({
            label,
            value
        }) => {
            $("#search_value").val(value);
        }
    });
});
</script>