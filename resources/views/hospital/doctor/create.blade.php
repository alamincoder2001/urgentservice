@extends("layouts.hospital.app")

@section("title", "Hospital Doctor Create Profile")
@push("style")
<link rel="stylesheet" href="https://unpkg.com/vue-select@latest/dist/vue-select.css">
<style>
    .table>tbody>tr>td {
        padding: 0 !important;
    }

    .table>thead>tr>th {
        padding: 0 !important;
    }

    .table>:not(:first-child) {
        border-top: 0;
    }
</style>
@endpush
@section("content")

<div class="row" id="doctor">
    <div class="col-md-12">
        <div class="card">
            <div class="card-heading text-end">
                <div class="card-title">
                    <a href="{{route('hospital.doctor.index')}}" class="btn btn-danger px-3">Back To Home</a>
                </div>
            </div>
            <div class="card-body">
                <form id="saveDoctor">
                    <div class="personal-info px-3">
                        <h5>Personal Information</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Name <small class="text-danger">*</small></label>
                                    <input type="text" v-model="doctor.name" name="name" class="form-control">
                                    <span class="error-name error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="username">Username<small class="text-danger">*</small></label>
                                    <input type="text" v-model="doctor.username" name="username" class="form-control">
                                    <span class="error-username error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="email">Email</label>
                                <input type="email" v-model="doctor.email" id="email" name="email" class="form-control">
                                <span class="error-email error text-danger"></span>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="password">Password<small class="text-danger">*</small></label>
                                    <input type="password" v-model="doctor.password" class="form-control" id="password" name="password">
                                    <span class="error-password error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="education">Education<small class="text-danger">*</small></label>
                                    <input type="text" v-model="doctor.education" name="education" class="form-control">
                                    <span class="error-education error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="department_id">Specialist<small class="text-danger">*</small></label>
                                    <v-select multiple :options="departments" v-model="selectedDepartment" label="name"></v-select>
                                    <span class="error-department_id error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="phone">Phone</label>
                                <div class="form-group m-0" v-for="(item, index) in phones">
                                    <div class="input-group">
                                        <input type="text" class="form-control" v-model="item.phone" />
                                        <button v-if="index == 0" @click="addPhone" type="button" class="btn btn-secondary btn-sm shadow-none"><i class="fa fa-plus"></i></button>
                                        <button v-if="index != 0" @click="removePhone(index)" type="button" class="btn btn-danger btn-sm shadow-none"><i class="fa fa-trash"></i></button>
                                    </div>
                                </div>
                                <span class="error-phone error text-danger"></span>
                            </div>
                            <div class="col-md-4">
                                <label for="first_fee">First Fee<small class="text-danger">*</small></label>
                                <div class="input-group">
                                    <input type="number" v-model="doctor.first_fee" id="first_fee" name="first_fee" class="form-control"><i class="btn btn-secondary">Tk</i>
                                </div>
                                <span class="error-first_fee error text-danger"></span>
                            </div>
                            <div class="col-md-4">
                                <label for="second_fee">Second Fee<small class="text-danger">*</small></label>
                                <div class="input-group">
                                    <input type="number" v-model="doctor.second_fee" id="second_fee" name="second_fee" class="form-control"><i class="btn btn-secondary">Tk</i>
                                </div>
                                <span class="error-second_fee error text-danger"></span>
                            </div>
                            <hr class="my-2">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <select v-model="daytime.day" class="form-control shadow-none">
                                        <option value="">Select Day</option>
                                        <option value="Sat">Sat</option>
                                        <option value="Sun">Sun</option>
                                        <option value="Mon">Mon</option>
                                        <option value="Tue">Tue</option>
                                        <option value="Wed">Wed</option>
                                        <option value="Thu">Thu</option>
                                        <option value="Fri">Fri</option>
                                    </select>
                                    <input type="time" v-model="daytime.fromTime" class="form-control shadow-none">
                                    <input type="time" v-model="daytime.toTime" class="form-control shadow-none">
                                    <button type="button" @click="addDayTime" class="btn btn-secondary btn-sm"><i class="fa fa-cart-plus"></i></button>
                                </div>
                                <table class="table table-bordered m-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Sl</th>
                                            <th class="text-center">Day</th>
                                            <th style="width:20%;" class="text-center">From</th>
                                            <th style="width:20%;" class="text-center">To</th>
                                            <th style="width:10%;" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, key) in daywiseTimeArray">
                                            <td class="text-center">@{{key + 1}}</td>
                                            <td class="text-center">@{{item.day}}</td>
                                            <td class="text-center">@{{item.fromTime}}</td>
                                            <td class="text-center">@{{item.toTime}}</td>
                                            <td class="text-center">
                                                <button type="button" @click="removeDayTime(key)" class="text-danger" style="border: 0;background:none;"><i class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <hr class="my-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="concentration">Concentration</label>
                                    <w-ckeditor-vue style="width: 100%;" v-model="doctor.concentration"></w-ckeditor-vue>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <w-ckeditor-vue style="width: 100%;" v-model="doctor.description"></w-ckeditor-vue>
                                </div>
                            </div>
                        </div>
                        <hr class="my-2">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="image">Doctor Image</label>
                                    <input type="file" class="form-control" id="image" name="image" onchange="document.querySelector('.img').src = window.URL.createObjectURL(this.files[0])">
                                    <span class="error-image error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="image">
                                    <img src="{{asset('noimage.jpg')}}" width="100" class="img" height="100">
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center mt-3">
                            <button type="submit" class="btn btn-success text-white text-uppercase px-3">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push("js")
<script src="https://cdn.jsdelivr.net/npm/vue@2.7.14"></script>
<script src="https://unpkg.com/vue-select@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<!-- ckeditor cdn -->
<script src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic@21.0.0/build/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/w-ckeditor-vue@2.0.4/dist/w-ckeditor-vue.umd.js"></script>
<script>
    Vue.component('v-select', VueSelect.VueSelect);
    Vue.component('w-ckeditor-vue', window['w-ckeditor-vue'])
    var app = new Vue({
        el: '#doctor',
        data: {
            doctor: {
                id: "{{$id}}",
                name: "",
                username: "",
                email: "urgentservicebd@gmail.com",
                password: "",
                education: "",
                address: "",
                first_fee: 0,
                second_fee: 0,
                concentration: "",
                description: "",
                image: "",
            },
            cities: [],
            selectedCity: null,
            departments: [],
            selectedDepartment: null,
            hospitals: [],
            diagnostics: [],
            selectedChamber: {
                chamber_name: "",
                chamber_address: "",
            },
            phones: [{
                phone: '01721843819',
            }],

            //selection details
            daytime: {
                day: "",
                fromTime: "",
                toTime: "",
            },
            daywiseTimeArray: [],

            imageSrc: location.origin + "/noimage.jpg",
            changePassword: false,

        },
        created() {
            if (this.doctor.id != '') {
                this.getDoctor();
            }
            this.getCity();
            this.getDepartment();
        },
        methods: {
            getCity() {
                axios.get(location.origin + "/hospital/city-get")
                    .then(res => {
                        this.cities = res.data.data
                    })
            },
            getDepartment() {
                axios.get(location.origin + "/hospital/department-get")
                    .then(res => {
                        this.departments = res.data.data
                    })
            },

            getHospital() {
                axios.get(location.origin + "/hospital/hospital-get")
                    .then(res => {
                        this.hospitals = res.data.data
                    })
            },
            getDiagnostic() {
                axios.get(location.origin + "/hospital/diagnostic-get")
                    .then(res => {
                        this.diagnostics = res.data.data
                    })
            },

            onChangeHospital(sl) {
                if (this.carts[sl].selectedHospital == null) {
                    return
                }
                this.carts[sl].hospital_id = this.carts[sl].selectedHospital.id
            },
            onChangeDiagnostic(sl) {
                if (this.carts[sl].selectedDiagnostic == null) {
                    return
                }
                this.carts[sl].diagnostic_id = this.carts[sl].selectedDiagnostic.id
            },

            // daytime add
            addDayTime() {
                if (this.daytime.day == "") {
                    alert("Day select required")
                    return
                }
                if (this.daytime.fromTime == "") {
                    alert("From Time required")
                    return
                }
                if (this.daytime.toTime == "") {
                    alert("To Time required")
                    return
                }
                this.daywiseTimeArray.push(this.daytime)
                this.daytime = {
                    day: "",
                    fromTime: "",
                    toTime: "",
                }
            },

            // remove daytime
            removeDayTime(sl) {
                this.daywiseTimeArray.splice(sl, 1)
            },

            // add phone
            addPhone() {
                let data = {
                    phone: '',
                };
                this.phones.push(data)
            },

            // remove phone
            removePhone(sl) {
                this.phones.splice(sl, 1)
            },


            // save doctor
            async saveDoctor(event) {
                if (this.carts.length == 0) {
                    alert("Cart is empty")
                    return
                }
                let phone = "";
                this.phones.forEach((item, key) => {
                    if (key == 0) {
                        phone = item.phone;
                    } else {
                        phone += "," + item.phone;
                    }
                })
                let formdata = new FormData(event.target)
                formdata.append("image", this.doctor.image)
                formdata.append("departments", this.selectedDepartment == null ? "" : JSON.stringify(this.selectedDepartment))
                formdata.append("city_id", this.selectedCity == null ? "" : this.selectedCity.id)
                formdata.append("daywiseTimeArray", JSON.stringify(this.carts))
                formdata.append("phone", phone)
                formdata.append("concentration", this.doctor.concentration)
                formdata.append("description", this.doctor.description)

                let url;
                if (this.doctor.id == '') {
                    url = location.origin + "/hospital/doctor";
                } else {
                    formdata.append("id", "{{$id}}")
                    url = location.origin + "/hospital/doctor-update";
                }

                await axios.post(url, formdata)
                    .then(res => {
                        $.notify(res.data, "success")
                        if (this.doctor.id != "") {
                            location.href = "/hospital/doctor-create"
                        }
                        this.clearData()
                    })
            },


            imageUrl(event) {
                if (event.target.files[0]) {
                    let img = new Image()
                    img.src = window.URL.createObjectURL(event.target.files[0]);
                    img.onload = () => {
                        if (img.width === 200 && img.height === 200) {
                            this.imageSrc = window.URL.createObjectURL(event.target.files[0]);
                            this.doctor.image = event.target.files[0];
                        } else {
                            alert(`This image ${img.width}px X ${img.height}px but require image 200px X 200px`);
                        }
                    }
                }
            },

            getDoctor() {
                axios.get(location.origin + "/admin/doctor-fetch/" + this.doctor.id)
                    .then(res => {
                        if (res.data.carts.length > 0) {
                            this.carts = []
                        }
                        let doctor = res.data.doctor
                        let carts = res.data.carts
                        this.doctor = {
                            name: doctor.name,
                            username: doctor.username,
                            email: doctor.email,
                            password: "",
                            education: doctor.education,
                            address: doctor.address,
                            first_fee: doctor.first_fee,
                            second_fee: doctor.second_fee,
                            concentration: doctor.concentration,
                            description: doctor.description == null ? "" : doctor.description,
                            image: doctor.image,
                        }
                        this.selectedCity = {
                            id: doctor.city_id,
                            name: doctor.city.name
                        }
                        let arrData = [];
                        doctor.department.forEach(item => {
                            let data = {
                                id: item.department_id,
                                name: item.specialist.name
                            }
                            arrData.push(data)
                        })
                        this.selectedDepartment = arrData

                        phones = doctor.phone.split(",");
                        this.phones = []
                        phones.forEach(item => {
                            this.phones.push({
                                phone: item
                            })
                        })

                        res.data.carts.forEach((item, key) => {
                            cart.daywiseTimeArray.push(d)
                        })
                        this.imageSrc = doctor.image == 0 ? location.origin + "/noimage.jpg" : location.origin + "/" + doctor.image;
                        this.changePassword = true
                    })
            },

            clearData() {
                this.doctor = {
                    name: "",
                    username: "",
                    email: "urgentservicebd@gmail.com",
                    password: "",
                    education: "",
                    address: "",
                    first_fee: 0,
                    second_fee: 0,
                    concentration: "",
                    description: "",
                    image: "",
                };
                this.phones = [{
                    phone: '01721843819',
                }]
                this.selectedDepartment = null
                this.selectedCity = null
                this.daywiseTimeArray = [];
                this.imageSrc = location.origin + "/noimage.jpg";
            },
        },
    })
</script>
@endpush