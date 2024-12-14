<template>


    <div class="content container-fluid">



        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            <span class="h4">الحضور والغياب الشهري</span>
                        </div>

                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-2">
                                <label for="status"> الموظف</label>

                                <select v-model="staff_selected" name="type" class="form-control " required>
                                    <option v-for="staff in staffs" v-bind:value="staff.id">
                                        {{ staff.name }}
                                    </option>
                                </select>

                            </div>

                            <div class="col-md-2">
                                <label for="status"> نوع التحضير</label>
                                <select v-model="attendance_type" class="form-control " required>
                                    <option v-bind:value=1>
                                        حاضر

                                    </option>

                                    <option v-bind:value=2>
                                        غايب
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="status">نظام العمل</label>
                                <select @change="get_period(work_selected)" v-model="work_selected" name="type"
                                    class="form-control " required>
                                    <option v-for="work_system in work_system_types" v-bind:value="work_system.id">
                                        {{ work_system.name }}
                                    </option>
                                </select>




                            </div>

                             <!--<div class="col-md-2">
                                <label for="status"> الفتره</label>
                                <select id='select_period' v-model="period_selected" name="type" class="form-control "
                                    required>

                                </select>
                            </div> -->

                            <div class="col-md-2">
                                <label for="status"> التأريخ</label>
                                <input class="form-control" type="date" name="" id="" v-model="attendance_date">


                            </div>

                            <div class="col-sm-6 col-md-2" style="margin-top: auto;">
                                <!-- <a href="#" onclick="get_time_for_all_staff(period_selected)"><img src="/assets/img/search.png"
                                    alt="" style="width: 15%;"> </a> -->

                                <a @click="get_staff_attendance(period_selected)" id="agregar_productos"
                                    data-target=".bs-example-modal-sm">
                                    <img src="/assets/img/search.png" alt="" style="width: 15%;"></a>
                            </div>



                        </div>




                    </div>


                </div>
            </div>
        </div>

        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">

                    <div class="card-body" id="printme">


                        <form action="post">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <!-- <th class="wd-15p border-bottom-0">الرقم الوظيفي</th> -->
                                            <th class="wd-10p border-bottom-0">اسم المؤظف</th>
                                            <!-- <th class="wd-10p border-bottom-0">الوظيفه</th> -->
                                            <th class="wd-10p border-bottom-0">التاريخ</th>
                                            <!-- <th class="wd-10p border-bottom-0">الفتره</th> -->

                                            <th class="wd-10p border-bottom-0"> الحضور</th>

                                            <th class="wd-10p border-bottom-0"> الغياب</th>

                                     
                                            <th class="wd-10p border-bottom-0"> التأخير</th>
                                            <th class="wd-10p border-bottom-0"> الانصراف  </th>
                                            <th class="wd-10p border-bottom-0"> الاضافي قبل الدوام</th>

                                            <th class="wd-10p border-bottom-0"> الاضافي بعد الدوام</th>



                                        </tr>
                                    </thead>
                                    <tbody v-if="value_list && value_list.data.length > 0">
                                        <tr v-for="(staff, indexs) in value_list.data" :key="indexs">
                                            <!-- <td>{{ staff.id }}</td> -->

                                            <!-- <input v-model="staff_id = staff.id" type="hidden" name="name" id="name"
                                            class="form-control" /> -->


                                            <td>{{ staff.attendance.staff.name }}</td>
                                            <td>{{ staff.attendance.attendance_date }}</td>

                                            <td>

                                        

                                            </td>

                                            <td>

                                            

                                            </td>











                                         








                                         

                                            <td>



   <a href="http://">{{ staff.delay }}</a>
                                            



                                            </td>
                                            <td>




                           
                                                <a href="http://">{{ staff.leave }}</a>

                                            </td>
                                            <td>




                               


                                    
                                                <a href="http://">{{ staff.extra }}</a>

                                            </td>

                                            <td>



                                                <div>
                                                    <a href="http://">{{ staff.extra_after }}</a>

                                                </div>


                                            </td>

                      






                                       



















                                        </tr>

                                        <tr>
                                            <td colspan="2" style="color: red;"> الاجمالي</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>

                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td align="center" colspan="3">لايوجد بياتات.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- <a href="javascript:void" @click="Add_new()" class="btn btn-success"><span>تاكيد
                    العمليه</span></a> -->
                        </form>
                        <pagination align="center" :data="staff_attendance" @pagination-change-page="list"></pagination>
                    </div>


                </div>
            </div>
        </div>



    </div>

</template>

<script>

import pagination from "laravel-vue-pagination";
import operation from '../../../../staff/operation/operation.js';

export default {
    components: {
        pagination,
    },
    mixins: [operation],
    data() {
        return {

            value_list: {
                type: Object,
                default: null,
            },


            attendance_type: '',
            attendance_date: new Date().toISOString().substr(0, 10),
            attendance_final: 'pendding',
            show: true,
            // attendance_date:0,
            status: [],
            check_in: [],
            check_out: [],
            time_in: [],
            time_out: [],
            check_attend: [],
            duration: [],
            delay: [],
            leave: [],
            extra: [],
            extra_after: [],

            check_state: [],
            date: [],
            fieldset1: [],
            fieldset2: [],
            fieldset3: [],
            staff: [],

            work_type_selected: '',
            staff_search: '',
            attendance_in_out: '',
            work_selected: '',
            period_selected: '',
            period_times: '',
            work_types: '',
            work_system_types: '',



        };
    },
    mounted() {
        this.list();
        this.type = 'attendance';
    },
    methods: {



        get_period(id) {


            axios.post(`/attendance/get_period/${id}`).then((response) => {

                console.log('muhib', response.data);
                this.period_times = response.data.periods
                this.work_types = response.data.work_types
                var arrayLength = response.data.periods.length
                var html = '<option></option>';

                for (var i = 0; i < arrayLength; i++) {

                    html = html + `<option data-period-${id}= ${response.data.periods[i].period_id}   value= ${response.data.periods[i].period_id} >${response.data.periods[i].name} من   ${response.data.periods[i].from_time}  الي ${response.data.periods[i].into_time}</option>`

                }


                $(`#select_period`).html(html);




            });
        },
        get_staff_attendance(id) {

            axios.post(`/attendance/get_staff_attendance/${id}`, {
                date: this.attendance_date,
                work_system_id: this.work_selected,
                period_id: this.period_selected
            }).then( //get_time_for_current_period
                (response) => {


                    this.value_list = response.data.staff_attendance;






                });
        },





        list(page = 1) {


            axios.post(`/attendance/get_staff_attendance?page=${page}`).then(
                (response) => {


                    this.staffs = response.data.staffs;
                    this.work_system_types = response.data.work_system_types;
                    this.value_list = response.data.staff_attendance;






                });



        },



    },
};
</script>
