<template>


    <div class="content container-fluid">



        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            <span class="h4">الحضور والغياب اليومي</span>
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

                            <div class="col-md-2">
                                <label for="status"> الفتره</label>
                                <select id='select_period' v-model="period_selected" name="type" class="form-control "
                                    required>

                                </select>
                            </div>

                            <div class="col-md-2">
                                <label for="status"> التأريخ</label>
                                <input class="form-control" type="date" name="" id="" v-model="attendance_date">


                            </div>

                            <!-- <div class="col-sm-6 col-md-2" style="margin-top: auto;">
                              

                                <a @click="get_staff_attendance(period_selected)" id="agregar_productos"
                                    data-target=".bs-example-modal-sm">
                                    <img src="/assets/img/search.png" alt="" style="width: 15%;"></a>
                            </div> -->

                            <div class="col-sm-6 col-md-2" style="margin-top: auto;">


                                <a @click="get_time_for_all_staff()" href="#">

                                    <i class="fa-solid fa-magnifying-glass fa-2xl" style="color: #74C0FC;"></i>


                                </a>


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
                                            <th class="wd-10p border-bottom-0">الفتره</th>

                                            <th class="wd-10p border-bottom-0">حاله الحضور</th>


                                            <th class="wd-10p border-bottom-0">دخول</th>
                                            <th class="wd-10p border-bottom-0">خروج</th>

                                            <th class="wd-10p border-bottom-0">عدد الساعات</th>
                                            <th class="wd-10p border-bottom-0">مده التأخير</th>
                                            <th class="wd-10p border-bottom-0"> الانصراف قبل الدوام</th>
                                            <th class="wd-10p border-bottom-0"> الاضافي قبل الدوام</th>

                                            <th class="wd-10p border-bottom-0"> الاضافي بعد الدوام</th>



                                            <!-- <th class="wd-15p border-bottom-0">العمليات</th> -->
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



                                                {{ staff.period.name }}




                                            </td>






                                            <td v-if="staff.attendance_status == 1">

                                                حاضر

                                            </td>

                                            <td v-if="staff.attendance_status == 0">

                                                غايب

                                            </td>











                                            <td>
                                                <input type="time" name="in" :value="staff.check_in">



                                            </td>


                                            <td>
                                                <input type="time" name="out" v-bind:id='"out" + indexs'
                                                    :value="staff.check_out">



                                            </td>








                                            <td>



                                                <input @keypress="calc_time(indexs)" type="text" class="form-control"
                                                    name="name" :value="staff.duration" readonly />
                                                <input type="hidden" class="form-control" name="name"
                                                    :value="staff.duration">

                                            </td>

                                            <td>




                                                <input type="text" class="form-control" :value="staff.delay" readonly>
                                                <input type="hidden" class="form-control" name="name"
                                                    :value="staff.delay">



                                            </td>
                                            <td>




                                                <input type="text" class="form-control" :value="staff.leave" readonly>
                                                <input type="hidden" class="form-control" readonly :value="staff.leave">



                                            </td>
                                            <td>




                                                <input type="text" class="form-control" :value="staff.extra" readonly>
                                                <input type="hidden" class="form-control" readonly :value="staff.extra">





                                            </td>

                                            <td>



                                                <div>

                                                    <input type="text" class="form-control" :value="staff.extra_after"
                                                        readonly>
                                                    <input type="hidden" class="form-control" readonly
                                                        :value="staff.extra_after">
                                                </div>


                                            </td>





                                            <!-- <template v-else>
                                                <div style="display: flex;">



                                                    <td>
                                                        <label for="in" style="color:red"> حضور</label>
                                                        <input type="time" name="in" v-bind:id='"in" + indexs'>


                                                    </td>


                                                    <td>
                                                        <label for="out" style="color:red"> انصراف</label>
                                                        <input type="time" name="out" v-bind:id='"out" + indexs'>


                                                    </td>






                                                </div>

                                                <td>


                                                    <input @keypress="calc_time(indexs)" type="text"
                                                        class="form-control" name="name"
                                                        v-bind:id='"attendance_duration" + indexs' />
                                                    <input v-bind:id='"attendance_duration_hidden" + indexs'
                                                        type="hidden" class="form-control" name="name">


                                                </td>
                                                <td>
                                                    <input v-bind:id='"attendance_delay" + indexs' type="text"
                                                        class="form-control">
                                                    <input type="hidden" v-bind:id='"attendance_delay_hidden" + indexs'
                                                        class="form-control" name="name">

                                                </td>
                                                <td>
                                                    <input v-bind:id='"attendance_leave" + indexs' type="text"
                                                        class="form-control">
                                                    <input type="hidden" v-bind:id='"attendance_leave_hidden" + indexs'
                                                        class="form-control" readonly>

                                                </td>
                                                <td>
                                                    <input v-bind:id='"attendance_extra" + indexs' type="text"
                                                        class="form-control">
                                                    <input v-bind:id='"attendance_extra_hidden" + indexs' type="hidden"
                                                        class="form-control">




                                                </td>

                                                <td>


                                                    <input v-bind:id='"attendance_extra_s" + indexs' type="text"
                                                        class="form-control">
                                                    <input v-bind:id='"attendance_extra_s_hidden" + indexs'
                                                        type="hidden" class="form-control">

                                                </td>


                                            </template> -->




















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
