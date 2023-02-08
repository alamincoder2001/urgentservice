@extends("layouts.app")

@section("title", "Admin Investigation Page")

@section("content")
@php
$access = App\Models\UserAccess::where('user_id', Auth::guard('admin')->user()->id)
->pluck('permissions')
->toArray();
@endphp
<div class="row">
    <div class="col-5">
        <div class="card bodyInvestigation">
            <div class="card-heading">
                <div class="card-title">Create Investigation</div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="test_name">Test Name</label>
                    <select name="test_name" id="test_name" class="form-control" onchange="TestName(event)">
                        <option value="">Select Test Name</option>
                        @foreach($tests as $item)
                        <option class="tests test{{$item->id}}" data-price="{{$item->amount}}" value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="patient_name">Patient Name</label>
                            <input type="text" name="patient_name" id="patient_name" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="patient_phone">Patient Phone</label>
                            <input type="text" name="patient_phone" id="patient_phone" class="form-control" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-7">
        <div class="card" id="tableInvestigation">
            <div class="card-heading">
                <div class="card-title">Investigation List</div>
            </div>
            <div class="card-body">
                <form onsubmit="addInvestigation(event)">
                    <table class="table table-striped">
                        <thead style="background: #133346;border:0;">
                            <tr>
                                <th class="text-white">Test Name</th>
                                <th class="text-white">Unit Price</th>
                                <th class="text-white">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-4">
                            <div class="input-group">
                                <input type="number" oninput="Discount(event)" readonly class="form-control" name="discount" id="discount" value="0"><span class="btn btn-dark">%</span>
                            </div>
                        </div>
                        <div class="col-8 text-end">
                            <input type="hidden" id="TotalValue" name="alltotal" value="0">
                            <input type="hidden" id="total" value="0">
                            <span class="total" style="font-size: 20px;">Total: <span class="text-success">0</span> tk</span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" style="margin-top: 30px;">Save Investigation</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-heading">
                <div class="card-title">
                    Investigation List Result
                </div>
            </div>
            <div class="card-body">
                @if(in_array("investigation.index", $access))
                <table class="table Example">
                    <thead>
                        <tr>
                            <th>Patient Name</th>
                            <th>Patient Phone</th>
                            <th>Discount</th>
                            <th>Total Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@push("js")
<script>
    var editaccess = "{{in_array('investigation.edit', $access)}}"
    var deleteaccess = "{{in_array('investigation.destroy', $access)}}"
    // get test
    function TestName(event) {
        $(".bodyInvestigation").find(".test" + event.target.value).addClass("text-danger")
        var count = $("#tableInvestigation").find("tbody").html()
        if (event.target.value != "") {
            $("#tableInvestigation").find("#discount").prop("readonly", false)
            $.ajax({
                url: location.origin + "/admin/test/edit/" + event.target.value,
                method: "GET",
                success: res => {
                    let row = `
                            <tr class="${res.name.replaceAll(" ", "-")}">
                                <td class="${res.name.replaceAll(" ", "-")}">${res.name}</td>
                                <td class="${res.amount}">${res.amount}</td>
                                <td><span class="text-danger" style="cursor:pointer;" onclick="removeTest('${res.name}', ${res.amount}, ${res.id})">
                                <input type="hidden" name="test_id[]" value="${res.id}" />
                                Remove</span></td>
                            </tr>
                        `;
                    if (count != "") {
                        var total = $("#tableInvestigation").find(".total span").text()
                        var name = $("#tableInvestigation").find("tbody ." + res.name.replaceAll(" ", "-") + " ." + res.name.replaceAll(" ", "-")).text()
                        if (name != res.name) {
                            $(".bodyInvestigation").find("select option:first-child").prop("selected", true)
                            $("#tableInvestigation").find("tbody").append(row)
                            $("#tableInvestigation").find(".total span").text(+Number(total) + res.amount)
                            $("#tableInvestigation").find("#TotalValue").val(+Number(total) + res.amount)
                            $("#tableInvestigation").find("#total").val(+Number(total) + res.amount)
                        }
                    } else {
                        $(".bodyInvestigation").find("select option:first-child").prop("selected", true)
                        $("#tableInvestigation").find(".total span").text(res.amount)
                        $("#tableInvestigation").find("#TotalValue").val(res.amount)
                        $("#tableInvestigation").find("#total").val(res.amount)
                        $("#tableInvestigation").find("tbody").append(row)
                    }
                }
            })
        }
    }
    // remove test
    function removeTest(name, amount, id) {
        $(".bodyInvestigation").find("select option:first-child").prop("selected", true)
        var count = $("#tableInvestigation").find("tbody tr")
        var TotalValue = $("#tableInvestigation").find("#TotalValue");
        var discount = $("#tableInvestigation").find("#discount");
        var total = $("#tableInvestigation").find(".total span");
        var amount = $("#tableInvestigation").find("tbody ." + name.replaceAll(" ", "-") + " ." + amount).text()
        TotalValue.val(Number(TotalValue.val()) - Number(amount))
        $("#tableInvestigation").find("#total").val(Number(TotalValue.val()) - Number(amount))
        total.text(Number(TotalValue.val()) - Number(TotalValue.val()) * discount.val() / 100)
        $("#tableInvestigation").find("tbody ." + name.replaceAll(" ", "-")).remove();
        $(".bodyInvestigation").find(".test" + id).removeClass("text-danger")
        if (count.length == 1) {
            $("#tableInvestigation").find("#discount").prop("readonly", true)
            discount.val(0)
            total.text(0)
            TotalValue.val(0)
        }
    }

    function addInvestigation(event) {
        event.preventDefault()
        var patient_name = $(".bodyInvestigation").find("#patient_name").val()
        var patient_phone = $(".bodyInvestigation").find("#patient_phone").val()
        var count = $("#tableInvestigation").find("tbody").html()
        var total = $("#tableInvestigation").find(".total span").text()
        var formdata = new FormData(event.target)
        formdata.append("total", Number(total))
        formdata.append("patient_name", patient_name)
        formdata.append("patient_phone", patient_phone)
        if (count != 0) {
            if (patient_name == "") {
                alert("Patient name is empty!")
                $(".bodyInvestigation").find("#patient_name").focus()
                return
            }
            if (patient_phone == "") {
                alert("Patient phone is empty!")
                $(".bodyInvestigation").find("#patient_phone").focus()
                return
            }

            $.ajax({
                url: location.origin + "/admin/investigation",
                method: "POST",
                data: formdata,
                processData: false,
                contentType: false,
                success: res => {
                    clearVal()
                    table.ajax.reload()
                    $.notify(res, "success");
                }
            })
        } else {
            alert("Cart is empty")
        }
    }

    function Discount(event) {

        var oldValue = $("#tableInvestigation").find("#TotalValue").val()
        if (event.target.value >= 0 && event.target.value <= 100) {
            var total = (Number(oldValue) * Number(event.target.value)) / 100;
            var newValue = $("#tableInvestigation").find(".total span").text(Number(oldValue) - total)
        } else {
            $("#tableInvestigation").find("#discount").val(0)
            $("#tableInvestigation").find(".total span").text(Number(oldValue))
        }
    }

    function clearVal() {
        $("#tableInvestigation").find("tbody").html("")
        $("#tableInvestigation").find("#discount").val(0)
        $("#tableInvestigation").find(".total span").text("0")
        $(".bodyInvestigation").find("#patient_name").val("")
        $(".bodyInvestigation").find("#patient_phone").val("")
        $("#tableInvestigation").find("#discount").prop("readonly", true)
        $(".bodyInvestigation").find(".tests").removeClass("text-danger")
    }

    var table = $('.Example').DataTable({
        // processing: true,
        ajax: location.origin + "/admin/fetch-investigation",
        columns: [{
                data: 'patient_name',
            },
            {
                data: 'patient_phone',
            },
            {
                data: null,
                render: (data) => {
                    return data.total * data.discount / 100 + " tk" + " (" + Number(data.discount) + "%)"
                }
            },
            {
                data: null,
                render: (data) => {
                    return Number(data.total_amount) + " tk"
                }
            },
            {
                data: null,
                render: (data) => {
                    return `
                            ${deleteaccess?'<button type="button" class="btn btn-danger btn-sm deleteInvestigation" value="'+data.id+'">Delete</button>':''}
                            <a href="/admin/investigation-show/${data.id}" class="btn btn-success btn-sm" value="${data.id}">Show Investigation</a>
                        `;
                }
            }
        ],
    });

    //delete investigation
    $(document).on("click", ".deleteInvestigation", event => {
        if (confirm("Are you sure want to delete this")) {
            $.ajax({
                url: location.origin + "/admin/investigation-delete/" + event.target.value,
                method: "GET",
                success: res => {
                    $.notify(res, "success")
                    table.ajax.reload()
                }
            })
        }
    })
</script>
@endpush