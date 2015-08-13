function fill_form(obj){
    document.getElementById('product_title').setAttribute('value',obj.childNodes[1].innerHTML);
    document.getElementById('product_description').innerHTML = obj.childNodes[3].innerHTML;
    document.getElementById('product_id').setAttribute('value', obj.childNodes[5].childNodes[1].getAttribute('value'));
}
function clear_form(){
    document.getElementById('product_title').setAttribute('value',"");
    document.getElementById('product_description').innerHTML = "";
    document.getElementById('product_id').setAttribute('value',"");
}