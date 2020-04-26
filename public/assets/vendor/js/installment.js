$(document).ready(function () {
    // product page start
    $('#product_table').DataTable();
    // product page end
    // make order page start

    $( "#datepicker" ).datepicker({
        changeYear:true,
        changeMonth:true,

    });
    $( "input[type=radio]" ).checkboxradio();
    $('#down_payment').on("change keyup paste click", function(){

        if ( $('#reduced_price').val() === '' ){

            var base_price = parseFloat($('#base_price').val()) || 0;
            var down_payment = parseFloat($('#down_payment').val()) || 0;
            var due_amount = base_price - down_payment;
            $('#due_amount').val(due_amount);
            $('#total_paid').val(down_payment);
        }
        else if( $('#reduced_price').val() !== '' ){
            var reduced_price = parseFloat($('#reduced_price').val()) || 0;
            var down_payment = parseFloat($('#down_payment').val()) || 0;
            var due_amount = reduced_price - down_payment;
            $('#due_amount').val(due_amount);
            $('#total_paid').val(down_payment);
        }

    });

    $("input:radio[name=procedure]").click(function(){
        // Do something interesting here
        if ($(this).val() === 'per_amount') {
            $('#per_amount').attr('readonly', false);
            $('#no_of_install').attr('readonly', true);

            $('#no_of_install').val("");
            $('#per_amount').val("");

            $('#per_amount').on("change keyup paste click", function () {
                var due_amount = parseFloat( $('#due_amount').val() );
                var per_amount = parseFloat($('#per_amount').val()) || 0;
                var no_of_installment = due_amount / per_amount ;
                $('#no_of_install').val(no_of_installment);
            });

        } else if ($(this).val() === 'num_of_install') {
            $('#no_of_install').attr('readonly', false);
            $('#per_amount').attr('readonly', true);

            $('#per_amount').val("");
            $('#no_of_install').val("");

            $('#no_of_install').on("change keyup paste click", function () {
                var due_amount = parseFloat( $('#due_amount').val() );
                var no_of_install = parseFloat($('#no_of_install').val()) || 0;
                var per_installment_amount = due_amount / no_of_install ;
                $('#per_amount').val(per_installment_amount);
            });
        }
    });

    $('#customer_id').on("change",function () {
        var customer_id = $('#customer_id').val();
        $.ajax({
            type: "GET",
            url: "/searchCustomerForOrder",
            data: { customer_id :customer_id },
            datatype: 'json',
            success: function(data){
                $('#cus_phone').val(data.cus_phone);
                $('#cus_email').val(data.cus_email);
                $('#cus_address').val(data.cus_address);
            }
        });

    });
    // make order page end
    // Running order page start
        // ## for table using jquery bootstrap
    $('.dtBasicExample').DataTable({
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            // Total over all pages
            total = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Total over this page
            pageTotal = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api.column( 5 ).footer() ).html(
                '৳'+pageTotal +' ( ৳'+ total +' total)',
                'hello'
            );


        }
    });
    // Running order page end
    // Updated order page start
    // ## update status start ##
    var fullDate = new Date();
    //convert month to 2 digits<p>
    var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);
    var currentDate =  fullDate.getFullYear()+ "-" + twoDigitMonth + "-" + fullDate.getDate();
    var date = currentDate;
    $('.fetchDate').val(currentDate);
    $( ".fetchDate" ).datepicker({
        changeYear:true,
        changeMonth:true,
    });
    // ## update status end ##
    // ## view note ##
    $('.view_data').on("click",function () {
        var order_id = $('#order_id').val();
        var note_id = $(this).attr("id");

        $.ajax({
            type:"GET",
            url: "/viewNoteDetails",
            data: {order_id: order_id, note_id: note_id} ,
            datatype: "json",
            success: function (data) {
                $('#note_date').html(data.date);
                $('#note_details').html(data.note);
                $('#exampleModal').modal("show");
            }
        });
    });
    // update note
    $('.update_note').on("click",function () {
        var order_id = $('#order_id').val();
        var note_id = $(this).attr("id");
        $.ajax({
            type:"GET",
            url: "/viewNoteDetails",
            data: {order_id: order_id, note_id: note_id} ,
            datatype: "json",
            success: function (data) {
                $('#noteUpdateModal').modal("show");
                $('.note_date').html(data.date);
                $('#prev_note').val(data.note);
                $('#note_id').val(data.note_id);
            }
        });
    });
    // edit note
    $('#edit_note').on("click",function () {
        var main_order_id = $('#main_order_id').val();
        var note_id = $('#note_id').val();
        var prev_note = $('#prev_note').val();
        var _token = $('input[name="_token"]').val();
        console.log(main_order_id,note_id,prev_note,_token);
        $.ajax({
            type: "POST",
            url: "/updateNote",
            data: {main_order_id: main_order_id, note_id: note_id, prev_note: prev_note, _token: _token},
            datatype: "json",
            success: function (data) {
                $('#noteUpdateModal').modal("hide");
                // alert("Note Updated Successfully");
                // location.reload();
            }
        });
    });
    // Updated order page end

    // defaulters table start
    $( "#defaulterPageLoad" ).load( "no url rn",function() {
        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

            $('#start').val(start.format('MMMM D, YYYY'));
            $('#end').val(end.format('MMMM D, YYYY'));

            onloadDefaulters();

        }


        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);

        function onloadDefaulters(){
            var start = $('#start').val();
            var end = $('#end').val();
            var _token = $('input[name="_token"]').val();

            $.ajax({
                type: "POST",
                url: "/defaultersDateSearch",
                data: {start_date: start, end_date: end,  _token: _token},
                datatype: "json",
                beforeSend: function() {
                    // setting a timeout
                    $('#loading').show();
                    $('#output').hide();

                },
                success: function (data) {
                    $('#output').html(data.output);
                    // defaulters table start
                    $('.defaulter_table').DataTable({
                        "footerCallback": function ( row, data, start, end, display ) {
                            var api = this.api(), data;

                            // Remove the formatting to get integer data for summation
                            var intVal = function ( i ) {
                                return typeof i === 'string' ?
                                    i.replace(/[\$,]/g, '')*1 :
                                    typeof i === 'number' ?
                                        i : 0;
                            };

                            // Total over all pages
                            total = api
                                .column( 5 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );

                            // Total over this page
                            pageTotal = api
                                .column( 5, { page: 'current'} )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );

                            // Update footer
                            $( api.column( 5 ).footer() ).html(
                                '৳'+pageTotal +' ( ৳'+ total +' total)',
                                'hello'
                            );


                        }
                    });
                    // defaulters table end
                },
                complete: function() {
                    $('#loading').hide();
                    $('#output').show();
                },
            });
        }
    });
    // defaulters table end
    // Account table start
    $( "#accountPageLoad" ).load( "no url rn",function() {
        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

            $('#start').val(start.format('MMMM D, YYYY'));
            $('#end').val(end.format('MMMM D, YYYY'));

            onloadAccount();

        }


        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);

        function onloadAccount(){
            var start = $('#start').val();
            var end = $('#end').val();

            $.ajax({
                type: "GET",
                url: "/accountsPerDate",
                data: {start_date: start, end_date: end},
                datatype: "json",
                beforeSend: function() {
                    // setting a timeout
                    $('#loading').show();
                    $('#output').hide();

                },
                success: function (data) {
                    $('#output').html(data.output);
                    // defaulters table start
                    $('.account_table').DataTable({
                        "footerCallback": function ( row, data, start, end, display ) {
                            var api = this.api(), data;

                            // Remove the formatting to get integer data for summation
                            var intVal = function ( i ) {
                                return typeof i === 'string' ?
                                    i.replace(/[\$,]/g, '')*1 :
                                    typeof i === 'number' ?
                                        i : 0;
                            };

                            // Total over all pages
                            total = api
                                .column( 4 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );

                            // Total over this page
                            pageTotal = api
                                .column( 4, { page: 'current'} )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );

                            // Update footer
                            $( api.column( 4 ).footer() ).html(
                                '৳'+pageTotal +' ( ৳'+ total +' total)',
                                'hello'
                            );


                        }
                    });
                    // defaulters table end
                },
                complete: function() {
                    $('#loading').hide();
                    $('#output').show();
                }
            });
        }
    });
    // Account table end

});
