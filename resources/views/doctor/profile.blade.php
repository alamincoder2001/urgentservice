@extends("layouts.doctor.app")

@section("title", "Doctor Dashboard")

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
    <div class="col-xl-4">
        <div class="card card-white">
            <div class="card-heading clearfix">
                <h6 class="text-info"><span>Profile</span> of~ {{Auth::guard('doctor')->user()->name}}</h6>
            </div>
            <div class="card-body user-profile-card">
                <img src="{{asset(Auth::guard('doctor')->user()->image != '0' ? Auth::guard('doctor')->user()->image:'/uploads/nouserimage.png')}}" class="user-profile-image rounded-circle" alt="{{Auth::guard('doctor')->user()->name}}">
                <h4 class="text-center m-t-lg">{{Auth::guard('doctor')->user()->name}}</h4>
                <h5 class="text-center"><i class="fas fa-book pe-1" style="font-size: 15px;color:#0014ff;"></i>{{Auth::guard('doctor')->user()->education}}</h5>
                <p class="text-center">{{Auth::guard('doctor')->user()->speciality}}</p>
                <hr>
                <ul class="list-unstyled text-center">

                    <li>
                        <p>
                            <i class="fas fa-map-marker-alt m-r-xs"></i>
                            @if(Auth::guard('doctor')->user()->chamber_name)
                            {{Auth::guard('doctor')->user()->address}}
                            @else
                            @if(Auth::guard('doctor')->user()->hospital_id)
                            {{Auth::guard('doctor')->user()->hospital->address}}
                            @elseif(Auth::guard('doctor')->user()->diagnostic_id)
                            {{Auth::guard('doctor')->user()->diagnostic->address}}
                            @else
                            @endif
                            @endif
                        </p>
                    </li>
                </ul>
                <hr>
                <p><i class="far fa-paper-plane m-r-xs"></i><a href="#">{{Auth::guard('doctor')->user()->email}}</a></p>
                <span>Created: <small>{{date('d.m.Y', strtotime(Auth::guard('doctor')->user()->created_at))}}</small></span>
            </div>
        </div>
    </div>
    <div class="col-xl-8">
        <div class="card card-white">
            <div class="card-heading clearfix">
                <h4 class="card-title">Doctor Profile</h4>
                <form @submit.prevent="saveDoctor">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" v-model="doctor.name" id="name" class="form-control" name="name">
                                    <span class="error-name error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" id="username" class="form-control" name="username" v-model="doctor.username">
                                    <span class="error-username error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" class="form-control" name="email" v-model="doctor.email">
                                    <span class="error-email error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="education">Education</label>
                                    <input type="text" id="education" class="form-control" name="education" v-model="doctor.education">
                                </div>
                                <span class="error-education error text-danger"></span>
                            </div>
                            <div class="col-md-6">
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="city_id">City Name<small class="text-danger">*</small></label>
                                    <v-select :options="cities" v-model="selectedCity" label="name"></v-select>
                                </div>
                                <span class="error-city_id text-danger error"></span>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="department_id">Specialist<small class="text-danger">*</small></label>
                                    <v-select multiple :options="departments" v-model="selectedDepartment" label="name"></v-select>
                                    <span class="error-department_id error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="first_fee">First Fee</label>
                                    <div class="input-group">
                                        <input type="number" id="first_fee" class="form-control" name="first_fee" v-model="doctor.first_fee"><i class="btn btn-secondary">Tk</i>
                                    </div>
                                    <span class="error-first_fee error text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="second_fee">Second Fee</label>
                                    <div class="input-group">
                                        <input type="number" id="second_fee" class="form-control" name="second_fee" v-model="doctor.second_fee"><i class="btn btn-secondary">Tk</i>
                                    </div>
                                    <span class="error-second_fee error text-danger"></span>
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row" v-for="(cart, sl) in carts" style="position:relative;border: 1px solid #e1e1e1;padding: 5px 0;margin: 0;margin-bottom: 5px;">
                                        <span @click="removeCart(sl)" style="cursor:pointer;position: absolute;background: red;width: 20px;height: 25px;top: -12px;right: -15px;z-index: 99999;border-radius: 50%;color: white;padding: 2px 6px;">X</span>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <select v-model="cart.selectby" class="form-select shadow-none mb-2">
                                                    <option value="">Select Module</option>
                                                    <option value="chamber">Chamber</option>
                                                    <option value="hospital">Hospital</option>
                                                    <option value="diagnostic">Diagnostic</option>
                                                </select>
                                                <!-- chamber details -->
                                                <input v-if="cart.selectby == 'chamber'" type="text" v-model="cart.chamber_name" class="form-control shadow-none mb-2" placeholder="chamber name">
                                                <textarea v-if="cart.selectby == 'chamber'" v-model="cart.chamber_address" class="form-control shadow-none mb-2" placeholder="chamber address"></textarea>
                                                <!-- hospital details -->
                                                <v-select v-if="cart.selectby == 'hospital'" :options="hospitals" v-model="cart.selectedHospital" label="name" @input="onChangeHospital(sl)"></v-select>
                                                <!-- diagnostic details -->
                                                <v-select v-if="cart.selectby == 'diagnostic'" :options="diagnostics" v-model="cart.selectedDiagnostic" label="name" @input="onChangeDiagnostic(sl)"></v-select>
                                            </div>
                                        </div>
                                        <div class="col-md-7" v-if="cart.selectby != ''">
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
                                                        <button type="button" @click="addDayTime(sl)" class="btn btn-secondary btn-sm"><i class="fa fa-cart-plus"></i></button>
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
                                                            <tr v-for="(item, key) in cart.daywiseTimeArray">
                                                                <td class="text-center">@{{key + 1}}</td>
                                                                <td class="text-center">@{{item.day}}</td>
                                                                <td class="text-center">@{{item.fromTime}}</td>
                                                                <td class="text-center">@{{item.toTime}}</td>
                                                                <td class="text-center">
                                                                    <button type="button" @click="removeDayTime(key, sl)" class="text-danger" style="border: 0;background:none;"><i class="fa fa-trash"></i></button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group text-end">
                                        <button type="button" @click="AddToCart" class="btn btn-warning text-white btn-sm px-4">Add Module</button>
                                    </div>
                                </div>
                            </div>

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
                            <div class="form-group text-center mt-4">
                                <button class="btn btn-primary px-3 text-uppercase">Update</button>
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
                id: "{{Auth::guard('doctor')->user()->id}}",
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

            carts: [{
                selectby: "",
                selectedHospital: null,
                selectedDiagnostic: null,
                hospital_id: "",
                diagnostic_id: "",
                chamber_name: "",
                chamber_address: "",
                daywiseTimeArray: [],
            }],

            imageSrc: location.origin + "/noImage.jpg",
            changePassword: false,

        },
        created() {
            if (this.doctor.id != '') {
                this.getDoctor();
            }
            this.getCity();
            this.getDepartment();
            this.getHospital();
            this.getDiagnostic();
        },
        methods: {
            getCity() {
                axios.get(location.origin + "/doctor/city-get")
                    .then(res => {
                        this.cities = res.data
                    })
            },
            getDepartment() {
                axios.get(location.origin + "/doctor/department-get")
                    .then(res => {
                        this.departments = res.data
                    })
            },

            getHospital() {
                axios.get(location.origin + "/doctor/hospital-get")
                    .then(res => {
                        this.hospitals = res.data
                    })
            },
            getDiagnostic() {
                axios.get(location.origin + "/doctor/diagnostic-get")
                    .then(res => {
                        this.diagnostics = res.data
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
            addDayTime(sl) {
                if (this.carts[sl].selectby == 'chamber' && this.carts[sl].chamber_name == '' && this.carts[sl].chamber_address == '') {
                    alert("Chamber name required or address required")
                    return
                }
                if (this.carts[sl].selectby == 'hospital' && this.carts[sl].selectedHospital == null) {
                    alert("Hospital name required")
                    return
                }
                if (this.carts[sl].selectby == 'diagnostic' && this.carts[sl].selectedDiagnostic == null) {
                    alert("Diagnostic name required")
                    return
                }
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
                this.carts[sl].daywiseTimeArray.push(this.daytime)
                this.daytime = {
                    day: "",
                    fromTime: "",
                    toTime: "",
                }
            },

            // remove daytime
            removeDayTime(sl, key) {
                this.carts[key].daywiseTimeArray.splice(sl, 1)
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

            // add to cart
            AddToCart() {
                let cart = {
                    selectby: "",
                    selectedHospital: null,
                    selectedDiagnostic: null,
                    chamber_name: "",
                    chamber_address: "",
                    daywiseTimeArray: [],
                }
                this.carts.push(cart)
            },

            removeCart(sl) {
                this.carts.splice(sl, 1)
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
                formdata.append("carts", JSON.stringify(this.carts))
                formdata.append("phone", phone)
                formdata.append("concentration", this.doctor.concentration)
                formdata.append("description", this.doctor.description)
                formdata.append("id", "{{Auth::guard('doctor')->user()->id}}")

                await axios.post("/doctor/doctor-update", formdata)
                    .then(res => {
                        $.notify(res.data, "success")
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
                axios.get(location.origin + "/doctor/doctor-fetch/" + this.doctor.id)
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
                            let cart = {
                                selectby: item.type,
                                hospital_id: item.hospital_id,
                                diagnostic_id: item.doctor_id,
                                chamber_name: item.chamber_name,
                                chamber_address: item.chamber_address,
                                daywiseTimeArray: [],
                            }
                            if (item.type == 'hospital') {
                                cart.selectedHospital = {
                                    id: item.hospital_id,
                                    name: item.hospital_name
                                }
                            } else {
                                cart.selectedHospital = null
                            }
                            if (item.type == 'diagnostic') {
                                cart.selectedDiagnostic = {
                                    id: item.diagnostic_id,
                                    name: item.diagnostic_name
                                }
                            } else {
                                cart.selectedDiagnostic = null
                            }

                            item.daywiseTimeArray.forEach(d => {
                                cart.daywiseTimeArray.push(d)
                            })

                            this.carts.push(cart)
                        })
                        this.imageSrc = doctor.image == 0 ? location.origin + "/noImage.jpg" : location.origin + "/" + doctor.image;
                        this.changePassword = true
                    })
            },
        },
    })
</script>
@endpush