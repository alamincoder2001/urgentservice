@extends("layouts.app")

@section("title", "Doctor Profile")

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
                    <a href="{{route('admin.doctor.index')}}" class="btn btn-danger px-3">Back To Home</a>
                </div>
            </div>
            <div class="card-body">
                <form @submit.prevent="saveDoctor">
                    <div class="personal-info px-3">
                        <h5>Personal Information</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Name <small class="text-danger">*</small></label>
                                    <input type="text" v-model="doctor.name" name="name" class="form-control" autocomplete="off">
                                    <span class="error-name error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="username">Username<small class="text-danger">*</small></label>
                                <input type="text" v-model="doctor.username" id="username" name="username" class="form-control" autocomplete="off">
                                <span class="error-username text-danger"></span>
                            </div>
                            <div class="col-md-4">
                                <label for="email">Email</label>
                                <input type="email" v-model="doctor.email" id="email" name="email" class="form-control" autocomplete="off">
                                <span class="error-email text-danger"></span>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="password">Password<small class="text-danger">*</small></label>
                                    <input type="password" v-model="doctor.password" class="form-control" id="password" name="password" autocomplete="off">
                                    <span class="error-password text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="education">Education<small class="text-danger">*</small></label>
                                    <input type="text" v-model="doctor.education" name="education" class="form-control" autocomplete="off">
                                    <span class="error-education error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="city_id">City Name<small class="text-danger">*</small></label>
                                    <v-select :options="cities" v-model="selectedCity" label="name"></v-select>
                                </div>
                                <span class="error-city_id text-danger error"></span>
                            </div>
                            <div class="col-md-2">
                                <label for="first_fee">First Fee<small class="text-danger">*</small></label>
                                <input type="number" id="first_fee" name="first_fee" class="form-control" autocomplete="off">
                                <span class="error-first_fee error text-danger"></span>
                            </div>
                            <div class="col-md-2">
                                <label for="second_fee">Second Fee<small class="text-danger">*</small></label>
                                <input type="number" id="second_fee" name="second_fee" class="form-control" autocomplete="off">
                                <span class="error-second_fee error text-danger"></span>
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
                                <div class="form-group" v-for="item in phone">
                                    <input type="text" class="form-control" :value="item"/>
                                </div>
                                <button @click="addPhone" type="button" class="btn btn-secondary btn-sm shadow-none"><i class="fa fa-plus"></i></button>
                                <span class="error-phone error text-danger"></span>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <select v-model="selectby" class="form-select shadow-none mb-2">
                                                <option value="">Select Module</option>
                                                <option value="chamber">Chamber</option>
                                                <option value="hospital">Hospital</option>
                                                <option value="diagnostic">Diagnostic</option>
                                            </select>
                                            <!-- chamber details -->
                                            <input v-if="selectby == 'chamber'" type="text" v-model="selectedChamber.chamber_name" class="form-control shadow-none mb-2" placeholder="chamber name">
                                            <textarea v-if="selectby == 'chamber'" v-model="selectedChamber.chamber_address" class="form-control shadow-none mb-2" placeholder="chamber address"></textarea>
                                            <!-- hospital details -->
                                            <v-select v-if="selectby == 'hospital'" :options="hospitals" v-model="selectedHospital" label="name"></v-select>
                                            <!-- diagnostic details -->
                                            <v-select v-if="selectby == 'diagnostic'" :options="diagnostics" v-model="selectedDiagnostic" label="name"></v-select>
                                        </div>
                                    </div>
                                    <div class="col-md-7" v-if="selectby != ''">
                                        <div class="row">
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
                                                <table class="table table-bordered">
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
                                                        <tr v-for="(item, sl) in daywiseTimeArray">
                                                            <td class="text-center">@{{sl + 1}}</td>
                                                            <td class="text-center">@{{item.day}}</td>
                                                            <td class="text-center">@{{item.fromTime}}</td>
                                                            <td class="text-center">@{{item.toTime}}</td>
                                                            <td class="text-center">
                                                                <button type="button" @click="removeDayTime(sl)" class="text-danger" style="border: 0;background:none;"><i class="fa fa-trash"></i></button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group text-end">
                                                    <button type="button" @click="AddToCart" class="btn btn-warning text-white btn-sm px-4">AddToCart</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row" style="padding:0 10px;" v-for="(cart, sl) in carts">
                                    <h5 class="m-0 text-center text-capitalize text-white" style="background:gray;">@{{cart.selectedType}}</h5>
                                    <div class="col-md-5 ps-0">
                                        <div class="form-group m-0">
                                            <input v-if="cart.selectedType == 'chamber'" type="text" class="form-control" :value="cart.chamber.chamber_name">
                                            <input v-if="cart.selectedType == 'hospital'" type="text" class="form-control" :value="cart.hospital.name" readonly>
                                            <input v-if="cart.selectedType == 'diagnostic'" type="text" class="form-control" :value="cart.diagnostic.name" readonly>
                                        </div>
                                        <div class="form-group m-0">
                                            <input v-if="cart.selectedType == 'chamber'" class="form-control" :value="cart.chamber.chamber_address">
                                            <input v-if="cart.selectedType == 'hospital'" class="form-control" :value="cart.hospital.address" readonly>
                                            <input v-if="cart.selectedType == 'diagnostic'" class="form-control" :value="cart.diagnostic.address" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-7 pe-0">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Sl</th>
                                                    <th class="text-center">Day</th>
                                                    <th style="width:20%;" class="text-center">From</th>
                                                    <th style="width:20%;" class="text-center">To</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(item, sl) in cart.daywiseTimeArray">
                                                    <td class="text-center">@{{sl + 1}}</td>
                                                    <td class="text-center">@{{item.day}}</td>
                                                    <td class="text-center">@{{item.fromTime}}</td>
                                                    <td class="text-center">@{{item.toTime}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
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
                            <div class="col-12 col-lg-2 d-flex justify-content-center align-items-center">
                                <div class="form-group ImageBackground">
                                    <img :src="imageSrc" class="imageShow" />
                                    <label for="image">Image</label>
                                    <input type="file" id="image" class="form-control shadow-none" @change="imageUrl" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group text-center mt-3">
                                    <button type="submit" class="btn btn-success text-white text-uppercase px-4">Save Doctor</button>
                                </div>
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
                name: "",
                username: "",
                email: "urgentservicebd@gmail.com",
                password: "",
                education: "",
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
            selectedHospital: null,
            diagnostics: [],
            selectedDiagnostic: null,
            selectedChamber: {
                chamber_name: "",
                chamber_address: "",
            },
            phone: ['01721843819'],

            //selection details
            selectby: "",
            daytime: {
                day: "",
                fromTime: "",
                toTime: "",
            },
            daywiseTimeArray: [],

            carts: [],

            imageSrc: location.origin + "/noImage.jpg",

        },
        created() {
            this.getCity();
            this.getDepartment();
            this.getHospital();
            this.getDiagnostic();
        },
        methods: {
            getCity() {
                axios.get(location.origin + "/admin/city-get")
                    .then(res => {
                        this.cities = res.data.data
                    })
            },
            getDepartment() {
                axios.get(location.origin + "/admin/department-get")
                    .then(res => {
                        this.departments = res.data.data
                    })
            },

            getHospital() {
                axios.get(location.origin + "/admin/hospital-get")
                    .then(res => {
                        this.hospitals = res.data.data
                    })
            },
            getDiagnostic() {
                axios.get(location.origin + "/admin/diagnostic-get")
                    .then(res => {
                        this.diagnostics = res.data.data
                    })
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
            addPhone(){
                this.phone.push("")
            },

            // add to cart
            AddToCart() {
                let cart = {
                    selectedType: this.selectby,
                    daywiseTimeArray: this.daywiseTimeArray
                }

                if (this.selectby == 'chamber') {
                    if (this.selectedChamber.chamber_name == '') {
                        alert("Chamber name required")
                        return
                    }
                    if (this.selectedChamber.chamber_address == '') {
                        alert("Chamber address required")
                        return
                    }
                    let chamber = {
                        chamber_name: this.selectedChamber.chamber_name,
                        chamber_address: this.selectedChamber.chamber_address
                    }
                    cart.chamber = chamber
                }
                if (this.selectby == 'hospital') {
                    if (this.selectedHospital == null) {
                        alert("Hospital name is required")
                        return
                    }
                    let hospital = {
                        id: this.selectedHospital.id,
                        name: this.selectedHospital.name,
                        address: this.selectedHospital.address
                    }
                    cart.hospital = hospital
                }
                if (this.selectby == 'diagnostic') {
                    if (this.selectedDiagnostic == null) {
                        alert("Diagnostic name is required")
                        return
                    }
                    let diagnostic = {
                        id: this.selectedDiagnostic.id,
                        name: this.selectedDiagnostic.name,
                        address: this.selectedDiagnostic.address
                    }
                    cart.diagnostic = diagnostic
                }

                this.carts.push(cart)
                this.daywiseTimeArray = [];
                this.selectedChamber = {
                    chamber_name: "",
                    chamber_address: "",
                }
                this.selectedHospital = null
                this.selectedDiagnostic = null
            },


            // save doctor
            saveDoctor(event) {
                let formdata = new FormData(event.target)
                formdata.append("image", this.doctor.image)
                formdata.append("departments", this.selectedDepartment == null ? "" : JSON.stringify(this.selectedDepartment))
                formdata.append("city_id", this.selectedCity == null ? "" : this.selectedCity.id)
                formdata.append("carts", JSON.stringify(this.carts))

                axios.post(location.origin + "/admin/doctor", formdata)
                    .then(res => {
                        console.log(res.data);
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
        },
    })
</script>
@endpush