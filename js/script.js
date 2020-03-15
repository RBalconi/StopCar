var area;
$(document).ready(function(){
    $('#content').load('../view/dashboard.php'); // Home Page load
    
    $(".call-screen-by-href").click(function(e){
        e.preventDefault();
        var href = $(this).attr('href');
        $("#content").load(href, function() {
            choosePage(href);       
        });
    });     
});

jQuery(function ($) {
    $(".sidebar-dropdown > a").click(function() {
        $(".sidebar-submenu").slideUp(200);
        if ($(this).parent().hasClass("active")) {
            $(".sidebar-dropdown").removeClass("active");
            $(this).parent().removeClass("active");
        } else {
            $(".sidebar-dropdown").removeClass("active");
            $(this).next(".sidebar-submenu").slideDown(200);
            $(this).parent().addClass("active");
        }
    });

    $("#close-sidebar").click(function() {
        $(".page-wrapper").removeClass("toggled");
    });
    $("#show-sidebar").click(function() {
        $(".page-wrapper").addClass("toggled");
    });   
});

function choosePage(href) {
    console.log(href);
    switch (href) {
        case '../client/clientMain.php':
            area = '../client/client';
            refreshList(area+'List.php');
            searchInputs();
            $('#form').load(area+'Form.php');
            
            break;
        case '../vehicle/vehicleMain.php':
            area = '../vehicle/vehicle';
            refreshList(area+'List.php');
            searchInputs();
            $('#form').load(area+'Form.php');

            break;
        case '../serviceOrder/serviceOrderMain.php':
            area = '../serviceOrder/serviceOrder';
            refreshList(area+'List.php');
            searchInputs();
            $('#form').load(area+'Form.php');
            
            break;
    }
}

function renderChart(idCanvas, data, labels, typeGraph, label, bgColor, xLabelString, yLabelString) {
    var ctx = document.getElementById(idCanvas).getContext('2d');
    return myChart = new Chart(ctx, {
        type: typeGraph,
        data: {
            labels: labels,
            datasets: [{
                label: label,
                data: data,
                backgroundColor: bgColor,
                pointBackgroundColor: 'rgba(0)'
            }]
        },
        options: {
            responsive: true,
            scales: {
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: xLabelString
                    }
                }], 
                yAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: yLabelString,
                    },
                    ticks: {
                        stepSize: 1,
                        beginAtZero: true

                    },
                }]
            }
        }
    });
}

function satatusDateReceveid() {
    if($('#radioReceiver').is(':checked')) { 
        alert("it's checked"); 
        $('#dateReceveid').val('');
    }else if($('#radioReceiveid').is(':checked')) { 
        $('#dateReceveid').val(dateToday());
    }
}

function statusOrderService() {
    if($('select[name=status]').val() == "Concluido"){
        $('#dateCompleted').val(dateToday());
    }
    if($('select[name=status]').val() != "Concluido"){
        $('#dateCompleted').val('');
    }
}



function disabledInputs(_action) {
    switch (_action) {
        case true:
            $(':input').attr('disabled','disabled');
            break;
        case false:
            $(':input').removeAttr('disabled');
            break;    
    }
    console.log('disabledInputs');
}
    
function dateToday(){
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    return today;
}

function openDivByAjax(_url){
    $.ajax({
        type: 'POST',
        url: _url,
        success: function(data){
            $('#content').html(data);
            choosePage(_url);
        }
    });
    return false;
}

function searchInputs() {  
    $('#selectItens').on('change', function() {
        changePage(1, this.value, $('#inputSearch').val(), area+'List.php');
    });
    $("#inputSearch").keyup(function() {
        changePage(1, $('#selectItens').val(), this.value, area+'List.php'); 
    });
}

function clearAllInputs(){
    // $(':input').val('');
    $(':input').not('.notClear').val(''); // .notClear - Class denying cleanup on input
    $("select").val($("select option:first").val());
    // $('#form')[0].reset();
    // $(':text').val('');
    // $('textarea').val(''); 
};

function changeTab(tabHref) {
    $('[href="#'+tabHref+'"]').tab('show');
};

function alert(type, timeShow) {
    switch (type) {
        case 'success':
            $('#alert').fadeTo(500, 0, function(){
                $('#alert').load('../util/alerts/success.php', function(){
                    $('#alert').fadeTo(800, 1).slideDown('slow');
                });
            });
            break;
        case 'error':
            $('#alert').fadeTo(500, 0, function(){
                $('#alert').load('../util/alerts/error.php', function(){
                    $('#alert').fadeTo(800, 1).slideDown('slow');
                });
            });
            break;
    }
    setTimeout(function(){
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove(); 
        });
    }, timeShow);
}

function openModal(id){
    $.ajax({
        type: 'POST',
        url: '../util/alerts/confirmModal.php',
        data: {code: id, area: area},
        success: function(data){              
            $('#modal').html(data);
            $('#modalCenter').modal('show');
        }
    });
    return false;
}

function changePage(_page, _itensPage, _search, _url) {
    $.ajax({
        type: "POST",
        url: _url,
        data: {page: _page, itensPage: _itensPage, search: _search},
        success: function (data) {
            $("#list").html(data);
            console.log('changePage');
        }
    });
    return false;
};

function refreshList(_url) {
    $.ajax({
        type: "POST",
        url: _url,
        success: function (data) {
            $("#list").html(data);
            console.log('refreshList');
        }
    });
    return false;
};

function sendForm(_formID, _url) {
    // console.log($('#'+_formID).serialize());
    $.ajax({
        type: 'POST',
        url: _url,
        data: $('#'+_formID).serialize(),
        success: function(data){
            alert('success', 4500);
            clearAllInputs(_formID);
            refreshList(area+'List.php');
            console.log('sendForm');
        },
        error: function() {
            alert('error', 4500);
        }
    });
    return false;
};

function deleteRegister(_id, _url) {
    $.ajax({
        type: "POST",
        url: _url,
        data: {code: _id},
        success: function (data) {
            refreshList(area+'List.php');
            console.log('deleteRegister');
        }
    });
    return false;
};

function insertDataEditForm(_id, _url, _enable){
    $.ajax({
        type: 'POST',
        url: _url,
        data: {code: _id},
        success: function(data){
            $("#form").html(data);
            disabledInputs(_enable);
            console.log('insertDataEditForm');
        }
    });
    return false;
};
