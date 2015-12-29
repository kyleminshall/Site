$("#convert-button").click(function() {

    var raw = $("#raw_text").val();
    
    var punctRE = /[\u2000-\u206F\u2E00-\u2E7F\\'!"#$%&()*+,\-.\/:;<=>?@\[\]^_`{|}~]/g;
    var spaceRE = /\s+/g;
    
    var result = raw.replace(punctRE, '').replace(spaceRE, ' ');
    result = result.toLowerCase();
    result = result.replace(/./g, "$& ")
    
    alert(result);
})