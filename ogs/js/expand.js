$(document).on('input.textarea', '.autoExpand', function(){
    var minRows = this.getAttribute('data-min-rows')|0,
        rows    = this.value.split("\n").length;

    this.rows = rows < minRows ? minRows : rows;
});