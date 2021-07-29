<script type="text/javascript">
$(document).ready(function() {
    var xhr = null;
    var field = document.getElementById('searchBox[{{$i}}]');
    ac[{{$i}}] = new Autocomplete(field, {
        data: [],
        maximumItems: {{Config::get("max_search_items")}},
        treshold: 1,
        onInput: function () {
            document.getElementById('search_value[{{$i}}]').value = -1
            var options = {};
            options.url = "{{ $search_url }}";
            options.type = "POST";
            options.data = {
                "name": document.getElementById('searchBox[{{$i}}]').value,
                "_token": "{{ csrf_token() }}"
            };
            options.dataType = "json";
            options.success = function (data) {
                ac[{{$i}}].setData(data);
                ac[{{$i}}].renderIfNeeded()
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
            document.getElementById('search_value[{{$i}}]').value = value
        }
    });
});
</script>