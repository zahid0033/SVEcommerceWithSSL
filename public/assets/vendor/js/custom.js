//tinymce
tinymce.init({
    selector: "textarea#textareatiny",
    plugins: [
        "advlist autolink link autolink preview image imagetools searchreplace table emoticons lists charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
        "table contextmenu directionality emoticons paste textcolor responsivefilemanager code"
    ],
    toolbar1: "undo redo | fontsizeselect bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
    toolbar2: "| responsivefilemanager | link unlink anchor autolink | image media imagetools preview  searchreplace table emoticons | forecolor backcolor  | print preview code ",
    image_advtab: true ,
    branding: false,
    fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",
    external_filemanager_path:"filemanager/",
    filemanager_title:"Responsive Filemanager" ,
    external_plugins: { "filemanager" : "filemanager/plugin.min.js"}
});
tinymce.init({
    selector: 'textarea.basic-example',
    height: 250,
    menubar: false,
    plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table paste code help wordcount'
    ],
    toolbar: 'undo redo | formatselect | ' +
        ' bold italic backcolor forecolor | alignleft aligncenter ' +
        ' alignright alignjustify | bullist numlist outdent indent |' +
        ' removeformat | help',
    branding: false,
    content_css: [
        '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
        '//www.tiny.cloud/css/codepen.min.css'
    ]
});
//tinymce #
//image preview
function previewImage(event)
{
    var reader = new FileReader();
    var imageField = document.getElementById("image-preview")
    reader.onload = function()
    {
        if(reader.readyState == 2)
        {
            imageField.src = reader.result;
        }
    }
    reader.readAsDataURL(event.target.files[0]);

    document.getElementById("image-field").style.visibility = "visible";
}
//multiple preview
$(function() {
    // Multiple images preview in browser
    var imagesPreview = function(input) {
        var $preview = $('#preview').empty();
        if (input.files) {
            var filesAmount = input.files.length;
            if (filesAmount <= 6)
            {
                for (i = 0; i < filesAmount; i++) {
                    var reader = new FileReader();
                    $(reader).on("load", function () {
                        $preview.append($("<img/>", {src: this.result, height: 100}));
                    });
                    reader.readAsDataURL(input.files[i]);
                }
            }
            else{alert('Maximum 6 Picture');}
        }
    };
    $('#image-preview').on('change', function() {
        imagesPreview(this);
    });
});
//multiple preview #
// image preview #
//gritter
function gritter_custom(gfor,title,text) {
    if(gfor == 'image upload')
    {
    $.gritter.add({
        // (string | mandatory) the heading of the notification
        title: title,
        // (string | mandatory) the text inside the notification
        text: text,
        image: 'assets/vendor/images/icon/bell.gif',
    });
    }
    return false;
}
//gritter #
//page = vendor>category_management
function setParentId(parent_id)
{
    //alert(parent_id);
    document.getElementById('categoryAdd_parentId').value = parent_id;
}
function setCatUpdate(id,name,description)
{
    //alert(parent_id);
    document.getElementById('cat_update_id').value = id ;
    document.getElementById('cat_update_name').value = name ;
    document.getElementById('cat_update_des').value = description ;
}
//page = vendor>category_management#
//page = vendor>product_management
function percentage_cal (){
let price = document.getElementById('pprice').value;
let offer_percentage = document.getElementById('poffer_percentage').value;
document.getElementById('poffer_price').value = parseInt(price - (parseInt(offer_percentage) * parseInt(price))/100);
}
//page = vendor>product_management#
//page = vendor>offer_management
$(document).on('change','#offer_type',function()
{
    let offer_type = document.getElementById('offer_type');
    let free_product_type = document.getElementById('free_product_type');
    let offer_percentage_type = document.getElementById('offer_percentage_type');
    if(offer_type.value == 'Buy one get one'){
        free_product_type.style.display = 'block';
        offer_percentage_type.style.display = 'none';
        document.getElementById('offer_percentage').value = '';
    }
    if(offer_type.value == 'Discount'){
        free_product_type.style.display = 'none';
        offer_percentage_type.style.display = 'block';
        var items = document.getElementsByName('free_product_ids[]');
        for (var i = 0; i < items.length; i++) {
            if (items[i].type == 'radio')
                items[i].checked = false;
        }
    }
});
//page = vendor>offer_management#
//page = vendor>order_management
function setOrderShipping(id,orderid,cn,courirer,date)
{
    document.getElementById('order_shipping_order_id').value = orderid ;
    document.getElementById('order_shippment_id').value = id ;
    document.getElementById('order_shipment_cn').value = cn ;
    document.getElementById('order_shipment_courier').value = courirer ;
    document.getElementById('order_shipment_date').value = date ;
}
//excel
//var excel_data ;
var excel_data ;
function getSearch(type)
{
    var daterange = document.getElementById('daterange').value;
    if(type === 'temp')
    {
        var search = document.getElementById('search_temp').value;
    }
    else if(type === 'main')
    {
        var search = document.getElementById('search_main').value;
    }
    else if(type === 'product')
    {
        var search = document.getElementById('search_product').value;
    }
    $.ajax({
        url: "/order_management/search",
        method: "GET",
        data: {search: search,type: type,daterange:daterange},
        dataType:'json',
        success: function(data)
        {
            $("#search_table").html(data.table_data);
            $("#search_total_record").html(data.total_data);
            // console.log(data.table_data);
            //console.log(data.order_id);
            excel_data = data.order_id.join();
            document.getElementById('excel_id').value = excel_data ;
            //console.log(excel_data);
        }
    });
}
function printDiv(divName)
{
    var nonp = document.getElementsByClassName('print_hide');
   /* document.getElementById('excelButton').disabled = true;
    document.getElementById('search_type').disabled = true;
    document.getElementById('search_main').disabled = true;
    document.getElementById('search_product').disabled = true;
    document.getElementById('printme').disabled = true;
    document.getElementById('printed').disabled = false;*/

    for(var i = 0; i < nonp.length; i++)
    {
        nonp[i].style.visibility = "hidden";
    }
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
    for(var i = 0; i < nonp.length; i++)
    {
        nonp[i].style.visibility = "visible";
    }
    /*document.getElementById('print_count').value = excel_data;*/
}
$(document).on('change','#search_type',function()
{
    let search_type = document.getElementById('search_type');
    /*let search_temp = document.getElementById('search_temp');*/
    let search_main = document.getElementById('search_main');
    let search_product = document.getElementById('search_product');
    if(search_type.value === 'main')
    {
       /* search_temp.style.display = 'none';*/
        search_main.style.display = 'block';
        search_product.style.display = 'none';
    }
   /*else if(search_type.value === 'temp')
   {
        search_temp.style.display = 'block';
        search_main.style.display = 'none';
        search_product.style.display = 'none';

   }*/
   else if(search_type.value === 'product')
   {
      /*  search_temp.style.display = 'none';*/
        search_main.style.display = 'none';
       search_product.style.display = 'block';

   }
});
//page = vendor>order_management#
//page = vendor>sales_management
$(function() {//date range picker
    var start = moment().subtract(0, 'years');
    var end = moment();
    function cb(start, end)
    {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        document.getElementById('daterange').value = start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY');
    }
    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        timePicker24Hour:false,
        timePicker: false,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);
});
//page = vendor>sales_management#
//page = vendor>customer_management
function getSearchCustomer()
{
    var search = document.getElementById('search_customer').value;
    $.ajax({
        url: "/customer_management/search",
        method: "GET",
        data: {search: search},
        dataType:'json',
        success: function(data)
        {
            $("#search_customer_table").html(data.table_data);
            $("#search_customer_total_record").html(data.total_data);
            // console.log(data.table_data);
            console.log(data.total_data);
        }
    });
}
//page = vendor>customer_management#
