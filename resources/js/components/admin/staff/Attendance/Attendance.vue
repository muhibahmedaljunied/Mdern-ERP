<template>
    <div class="container-fluid">
        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            <span class="h4">التحضير اليدوي</span>
                        </div>

                    </div>
                    <div class="card-body">

                        <div class="row">
                            <!-- <div class="col-md-2">
                                <label for="status"> وقت التحضير</label>
                                <select v-model="attendance_in_out" class="form-control " required>
                                    <option v-bind:value=1>
                                        دخول
                                    </option>
                                    <option v-bind:value=2>
                                        خروج
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="status"> نوع التحضير</label>
                                <select v-model="attendance_type" class="form-control " required>
                                    <option v-bind:value=1 selected>
                                        حاضر

                                    </option>

                                    <option v-bind:value=2>
                                        غايب
                                    </option>
                                </select>
                            </div> -->

                            <div class="col-md-4">

                                <label for="status"> الهيكل الاداري</label>

                                <!-- <input v-model="debit" type="hidden" class="form-control" required /> -->
                                <div class="custom-search">

                                    <input style="background-color: beige;" :id="'Advance_account_advance_tree'"
                                        type="text" readonly class="custom-search-input">
                                    <input :id="'Advance_account_advance_tree_id'" type="hidden" readonly
                                        class="custom-search-input">

                                    <button class="custom-search-botton" type="button" data-toggle="modal"
                                        data-target="#exampleModalAccountAdvance">
                                        <i class="fa fa-plus-circle"></i></button>
                                </div>


                            </div>
                            <div class="col-md-2">
                                <label for="status"> الموظف</label>

                                <select v-model="staff_selected" name="type" class="form-control " required>
                                    <option v-for="staff in staffs" v-bind:value="staff.staff_id">
                                        {{ staff.name }}
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
                                <label for="status"> التأريخ</label>
                                <input class="form-control" type="date" name="" id="" v-model="attendance_date">


                            </div>

                            <div class="col-sm-6 col-md-2" style="margin-top: auto;">


                                <a @click="get_time_for_all_staff()" id="agregar_productos"
                                    data-target=".bs-example-modal-sm">
                                    <img src="/assets/img/search.png" alt="" style="width: 15%;"></a>
                            </div>



                        </div>

                        <!-- <br>
                        <hr>
                        <div class="row">


                            <div class="col-md-2">



                                <label for="status"> الفتره</label>
                                <select @change="get_time(period_selected)" id='select_period' v-model="period_selected"
                                    name="type" class="form-control " required>

                                </select>





                            </div>


                            <div class="col-md-2">
                                <label> بدايه الفتره</label>

                                <span id="start_period">

                                    <input type="time" class="form-control">


                                </span>


                            </div>

                            <div class="col-md-2">
                                <label> نهايه الفتره</label>

                                <span id="end_period">
                                    <input type="time" class="form-control">


                                </span>


                            </div>

                            <div class="col-md-2">
                                <label> ترتيب الفتره</label>

                                <span id="sort_period">
                                    <input type="number" class="form-control">


                                </span>


                            </div>
                            <div class="col-md-2">
                                <label for="status"> الموظف</label>

                                <select v-model="staff_selected" name="type" class="form-control " required>
                                    <option v-for="staff in staffs" v-bind:value="staff.id">
                                        {{ staff.name }}
                                    </option>
                                </select>

                            </div>


                            <div class="col-sm-6 col-md-2" style="margin-top: auto;">
                          

                                <a @click="get_time_for_all_staff()" id="agregar_productos"
                                    data-target=".bs-example-modal-sm">
                                    <img src="/assets/img/search.png" alt="" style="width: 15%;"></a>
                            </div>

                        </div> -->



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
                                <table class="table table-bordered text-center" style="font-size: larger;">
                                    <thead>
                                        <tr>
                                            <th class="wd-10p border-bottom-0">اسم المؤظف</th>

                                            <th class="wd-10p border-bottom-0">نظام العمل</th>
                                            <th class="wd-10p border-bottom-0">الفتره</th>


                                            <th class="wd-5p border-bottom-0">التأريخ</th>

                                            <th class="wd-5p border-bottom-0">بدايه الفتره</th>
                                            <th class="wd-5p border-bottom-0">نهايه الفتره</th>
                                            <th class="wd-5p border-bottom-0"> دخول</th>
                                            <th class="wd-5p border-bottom-0"> خروج</th>

                                            <th class="wd-10p border-bottom-0">عدد الساعات</th>
                                            <th class="wd-10p border-bottom-0">مده التأخير</th>
                                            <th class="wd-10p border-bottom-0"> الانصراف قبل الدوام</th>
                                            <th class="wd-10p border-bottom-0"> الاضافي قبل الدوام</th>

                                            <th class="wd-10p border-bottom-0"> الاضافي بعد الدوام</th>


                                            <th>اضافه</th>

                                        </tr>
                                    </thead>
                                    <tbody v-if="value_list && value_list.data.length > 0">
                                        <tr v-for="(staff, index) in value_list.data" :key="index">


                                            <template
                                                v-if="staff.attendance">


                                                <td>{{ staff.attendance.staff.name }}</td>

                                                <td>{{ staff.attendance.attendance_date }}</td>
                                                <td colspan="12">

                                                    <span style="color: red;">حاضر</span>

                                                </td>
                                            </template> 

                                            <template v-else >
                                               

                                            <td>{{ staff.name }}</td>



                                            <td>{{ staff.type }}</td>

                                            <td>


                                                {{ staff.period }}

                                            </td>




                                            <td v-if="staff.attendance_date">

                                                {{ attendance_date }}
                                            </td>

                                            <td v-else>
                                                {{ attendance_date }}
                                            </td>

                                            <td>


                                                <input style="color: red;" type="time" name="in" v-bind:id='"from" + index'
                                                   :value="staff.from_time" >

                                            </td>


                                            <td>



                                                <input style="color: red;" type="time" name="out" v-bind:id='"into" + index'
                                                :value="staff.into_time" >

                                            </td>

                                            <td>


                                                <input type="time" name="in" v-bind:id='"in" + index' v-model="check_in[index]"
                                                    @change="calc_time(index, staff.from_time, staff.into_time)">

                                            </td>


                                            <td>



                                                <input type="time" name="out" v-bind:id='"out" + index' v-model="check_out[index]"
                                                    @change="calc_time(index, staff.from_time, staff.into_time)">

                                            </td>



                                            <td>


                                                <input type="text" class="form-control" name="name"
                                                    v-bind:id='"attendance_duration" + index' disabled />
                                                <input v-bind:id='"attendance_duration_hidden" + index' type="hidden"
                                                    class="form-control" name="name">


                                            </td>
                                            <td>
                                                <input v-bind:id='"attendance_delay" + index' type="text"
                                                    class="form-control" disabled>
                                                <input type="hidden" v-bind:id='"attendance_delay_hidden" + index'
                                                    class="form-control" name="name">

                                            </td>
                                            <td>
                                                <input v-bind:id='"attendance_leave" + index' type="text"
                                                    class="form-control" disabled>
                                                <input type="hidden" v-bind:id='"attendance_leave_hidden" + index'
                                                    class="form-control" readonly>

                                            </td>
                                            <td>
                                                <input v-bind:id='"attendance_extra" + index' type="text"
                                                    class="form-control" disabled>
                                                <input v-bind:id='"attendance_extra_hidden" + index' type="hidden"
                                                    class="form-control">




                                            </td>

                                            <td>


                                                <input v-bind:id='"attendance_extra_s" + index' type="text"
                                                    class="form-control" disabled>
                                                <input v-bind:id='"attendance_extra_s_hidden" + index' type="hidden"
                                                    class="form-control">

                                            </td>

                                            <td>

                                                <input @change="
                                                    add_one_attendance(
                                                        staff.period_id,
                                                        staff.staff_id,
                                                        index,
                                                        staff.from_time,
                                                        staff.into_time,
                                                        staff.sort,


                                                    )
                                                    " type="checkbox" v-model="check_state[index]"
                                                    class="btn btn-info waves-effect" />


                                            </td>

                                             </template>

                                       


                                            <!-- <td>{{ staff.work_system_type.name }}</td>
                                            <td>{{ staff.period_time.name }}</td>
                                       -->
                                            <!-- <td v-else>{{ staff.name }}</td> -->


                                            <!-- 
                                            <template
                                                v-if="staff.attendance && staff.attendance.attendance_final == 'complete'">


                                                <td>{{ staff.attendance.staff.name }}</td>

                                                <td>{{ staff.attendance.attendance_date }}</td>
                                                <td colspan="9">

                                                    <span style="color: red;">حاضر</span>

                                                </td>
                                            </template>


                                            <template
                                                v-if="staff.attendance && staff.attendance.attendance_final == 'pennding'"">


                                                <td>{{ staff.attendance.staff.name }}</td>

                                                <td>{{ staff.attendance.attendance_date }}</td>


                                                

         <td>
                                             
                                                        <input type="time" name="in" v-bind:id='"in" + index'
                                                            :value="staff.check_in">



                                                    </td>


                                                    <td>
                                
                                                        <input v-if="staff.attendance_final == 'complete'" type="time"
                                                            name="out" v-bind:id='"out" + indexs'
                                                            :value="details.check_out"> 
                                                        <input type="time" name="out" v-bind:id='"out" + index'>


                                                    </td>





                                        

                                                <td>


                                                    <input @keypress="calc_time(index)" type="text" class="form-control"
                                                        name="name" v-bind:id='"attendance_duration" + index'
                                                        readonly />
                                                    <input v-bind:id='"attendance_duration_hidden" + index'
                                                        type="hidden" class="form-control" name="name"
                                                        :value="staff.duration">


                                                </td>
                                                <td>

                                                    <input v-bind:id='"attendance_delay" + index' type="text"
                                                        class="form-control" readonly>
                                                    <input type="hidden" v-bind:id='"attendance_delay_hidden" + index'
                                                        class="form-control" name="name" :value="staff.delay">

                                                </td>
                                                <td>

                                                    <input v-bind:id='"attendance_leave" + index' type="text"
                                                        class="form-control" readonly>
                                                    <input type="hidden" v-bind:id='"attendance_leave_hidden" + index'
                                                        class="form-control" readonly :value="staff.leave">

                                                </td>
                                                <td>

                                                    <input v-bind:id='"attendance_extra" + index' type="text"
                                                        class="form-control" readonly>
                                                    <input v-bind:id='"attendance_extra_hidden" + index' type="hidden"
                                                        class="form-control" readonly :value="staff.extra">



                                                </td>

                                                <td>


                                                    <input v-bind:id='"attendance_extra_s" + index' type="text"
                                                        class="form-control" readonly>
                                                    <input v-bind:id='"attendance_extra_s_hidden" + index' type="hidden"
                                                        class="form-control" readonly :value="staff.extra">

                                                </td>


                                                <td>


                                                    <input @change="
                                                        add_one_attendance(
                                                            staff.attendance.staff.id,
                                                            staff.attendance.attendance_status,
                                                            index

                                                        )
                                                        " type="checkbox" v-model="check_state[index]"
                                                        class="btn btn-info waves-effect" />




                                                </td>

                                            </template>

                                            <template v-if="!staff.attendance">



                                                <td>{{ staff.name }}</td>

                                                <td>{{ attendance_date }}</td>

                                                <td>

                                                    <input type="time" name="in" v-bind:id='"in" + index'>


                                                </td>


                                                <td>

                                                    <input type="time" name="out" v-bind:id='"out" + index'>


                                                </td>








                                                <td>


                                                    <input @keypress="calc_time(index)" type="text" class="form-control"
                                                        name="name" v-bind:id='"attendance_duration" + index' />
                                                    <input v-bind:id='"attendance_duration_hidden" + index'
                                                        type="hidden" class="form-control" name="name">


                                                </td>
                                                <td>
                                                    <input v-bind:id='"attendance_delay" + index' type="text"
                                                        class="form-control">
                                                    <input type="hidden" v-bind:id='"attendance_delay_hidden" + index'
                                                        class="form-control" name="name">

                                                </td>
                                                <td>
                                                    <input v-bind:id='"attendance_leave" + index' type="text"
                                                        class="form-control">
                                                    <input type="hidden" v-bind:id='"attendance_leave_hidden" + index'
                                                        class="form-control" readonly>

                                                </td>
                                                <td>
                                                    <input v-bind:id='"attendance_extra" + index' type="text"
                                                        class="form-control">
                                                    <input v-bind:id='"attendance_extra_hidden" + index' type="hidden"
                                                        class="form-control">




                                                </td>

                                                <td>


                                                    <input v-bind:id='"attendance_extra_s" + index' type="text"
                                                        class="form-control">
                                                    <input v-bind:id='"attendance_extra_s_hidden" + index' type="hidden"
                                                        class="form-control">

                                                </td>

                                                <td>

                                                    <input @change="
                                                        add_one_attendance(
                                                            staff.staff_id,
                                                            staff.attendance_status,
                                                            index

                                                        )
                                                        " type="checkbox" v-model="check_state[index]"
                                                        class="btn btn-info waves-effect" />


                                                </td>

                                            </template>

 -->















                                        </tr>

                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td align="center" colspan="3">لايوجد بياتات.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-md-2">

                                <a href="javascript:void" @click="Add_new()" class="btn btn-success"><span>
                                        حفظ</span></a>


                            </div>
                        </form>
                        <pagination align="center" :data="value_list" @pagination-change-page="list"></pagination>
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
            staff_attendance: {
                type: Object,
                default: null,
            },

            attendance_type: 1,
            attendance_date: new Date().toISOString().substr(0, 10),
            attendance_final: 'pendding',
            show: true,
            // attendance_date:0,
            sort:[],
            period:[],
            staff_selected:[],
            time_checkin: [],
            time_checkout: [],
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
            // fieldset1: [],
            // fieldset2: [],
            // fieldset3: [],
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


        endTimeInput(index, from, into) {

            this.calc_time(index, from, into);
        },
        Add_new() {



            // alert($(`#code`).val());
            var type = this.get_type_of_leave_delay();

            this.axios
                .post(`/store_attendance`, {
                    type: this.type,
                    count: this.counts,
                    staff: this.staff,
                    period: this.period,
                    sort:this.sort,
                    code: $(`#code`).val(),
                    sort_period: $(`#sort_period_time`).val(),
                    attendance_date: this.attendance_date,
                    attendance_final: this.attendance_final,
                    work_type: this.work_type_selected,
                    attendance_status: this.attendance_type,
                    time_in: this.check_in,
                    time_out: this.check_out,
                    duration: this.duration,
                    delay: this.delay,
                    leave: this.leave,
                    extra: this.extra,
                    extra_after: this.extra_after,

                    type_leave_delay: type,

                    attendance_in_out: this.attendance_in_out,
                    work: this.work_selected,

                })
                .then((response) => {
                    // console.log(response);
                    toastMessage("تم الاضافه بنجاح");
                    // this.$router.go(0);
                });




        },
        get_type_of_leave_delay() {

            var split_in = this.attendance_date.split("-");

            var date_obj = new Date();
            var month = split_in[1];
            var day = split_in[2];
            // alert(month);
            var year = date_obj.getFullYear();

            const date_str = `${month}/${day}/${year}`
            const date = new Date(date_str);
            const full_day_name = date.toLocaleDateString('default', { weekday: 'short' });


            return full_day_name;




        },

        translate_time(index, time, h, m, type) {



            // console.log('translate_time', index, time, h, m, type);

            if (time % 60 == 0) {

                $(`#attendance_${type}${index}`).val(`${h}ساعه`);

            }
            if (time == 0) {

                $(`#attendance_${type}${index}`).val(0);

            }
            if (time < 60 && time > 0) {

                $(`#attendance_${type}${index}`).val(`${m}دقيقه`);
            }

            if (time > 60 && time % 60 != 0) {

                $(`#attendance_${type}${index}`).val(`${h}ساعه,${m}دقيقه`);

            }

            $(`#attendance_${type}_hidden${index}`).val(m + (h * 60));







        },
        calc_time(index, from, into) {


            var time, mm, hh;
            var time_result = 0, mm_result = 0, hh_result = 0;


            var split_in;
            var split_out;
            var date1
            var date2
            var date;


            this.check_in[index] = $(`#in${index}`).val();
            this.check_out[index] = $(`#out${index}`).val();
            split_in = this.check_in[index].split(":");
            split_out = this.check_out[index].split(":");

            date = this.attendance_date.split("-");
            date1 = new Date(date[0], date[1], date[2], split_in[0], split_in[1]); // 9:00 AM
            date2 = new Date(date[0], date[1], date[2], split_out[0], split_out[1]); // 5:00 PM


            if (date2 < date1) {

                date2.setDate(date2.getDate() + 1);
            }

            [time, mm, hh] = this.get_diff(date1, date2);
            time_result += time, mm_result += mm, hh_result += hh;



            this.duration[index] = time_result;

            this.translate_time(index, time_result, hh_result, mm_result, 'duration');

            this.calc_delay(index, from, into);
            this.calc_leave(index, from, into);
            this.calc_extra_before(index, from, into);
            this.calc_extra_after(index, from, into);

            // console.log('----------', split_in, split_out);






        },

        calc_delay(index, from, into) {


            var time_result = 0, mm_result = 0, hh_result = 0;
            [time_result, hh_result, mm_result] = this.loop_data(index, 'from', from, into, 'delay');
            // console.log('delay', time_result, hh_result, mm_result);
            this.delay[index] = time_result;
            this.translate_time(index, time_result, hh_result, mm_result, 'delay');








        },
        calc_extra_before(index, from, into) {

            var time_result = 0, mm_result = 0, hh_result = 0;
            [time_result, hh_result, mm_result] = this.loop_data(index, 'from', from, into, 'extra');
            this.extra[index] = time_result;
            this.translate_time(index, time_result, hh_result, mm_result, 'extra');


        },

        calc_extra_after(index, from, into) {




            var time_result = 0, mm_result = 0, hh_result = 0;
            [time_result, hh_result, mm_result] = this.loop_data(index, 'into', from, into, 'extra_s');
            this.extra_after[index] = time_result;
            this.translate_time(index, time_result, hh_result, mm_result, 'extra_s');





        },
        calc_leave(index, from, into) {


            var time_result = 0, mm_result = 0, hh_result = 0;
            [time_result, hh_result, mm_result] = this.loop_data(index, 'into', from, into, 'leave');
            this.leave[index] = time_result;
            this.translate_time(index, time_result, hh_result, mm_result, 'leave');             // if (time_result % 60 == 0) {


        },

        loop_data(index, type, from, into, x) {

            var time_result = 0, mm_result = 0, hh_result = 0;
            var time = 0, mm = 0, hh = 0;
            var date1, date2;
            var split_in, split_out
            // for (const key in period) {

            //     if (Object.prototype.hasOwnProperty.call(period, key)) {

            [split_in, split_out] = this.splite_time(index, type, from, into);
            [date1, date2] = this.get_date(split_in, split_out);
            // console.log('loop_data', x, split_in, split_out);

            if (x == 'delay' && type == 'from') {

                if (split_in < split_out) {

                    [time, mm, hh] = this.get_diff(date1, date2);

                } else {
                    time, mm, hh = 0;

                }

            }

            if (x == 'leave' && type == 'into') {

                if (split_in > split_out) {

                    [time, mm, hh] = this.get_diff(date1, date2);
                } else {

                    time, mm, hh = 0;

                }

            }


            if (x == 'extra' && type == 'from') {

                if (split_in > split_out) {

                    [time, mm, hh] = this.get_diff(date1, date2);
                } else {

                    time, mm, hh = 0;

                }

            }


            if (x == 'extra_s' && type == 'into') {

                if (split_in < split_out) {

                    [time, mm, hh] = this.get_diff(date1, date2);
                } else {

                    time = 0;
                    mm = 0;
                    hh = 0;


                }

            }


            time_result += time, mm_result += mm, hh_result += hh;



            //     }

            // }
            // console.log('delay', time_result, hh_result, mm_result);

            return [time_result, hh_result, mm_result];
        },

        splite_time(index, type, from, into) {


            var split_out;
            var split_in;
            if (type == 'from') {

                split_in = from.split(":");
                split_out = this.check_in[index].split(":");

            } else {
                split_in = into.split(":");
                split_out = this.check_out[index].split(":");

            }




            return [split_in, split_out]



        },
        get_date(split_in, split_out) {
            var date1, date2, date;
            var split_in;
            var split_out;
            var date;


            date = this.attendance_date.split("-");
            date1 = new Date(date[0], date[1], date[2], split_in[0], split_in[1]); // 9:00 AM
            date2 = new Date(date[0], date[1], date[2], split_out[0], split_out[1]); // 5:00 PM


            return [date1, date2];
        },
        get_diff(date1, date2) {


            var diff = 0;
            if (date1 < date2) {

                diff = date2 - date1;



            } else {


                diff = date1 - date2;
            }




            // ---------------------
            var msec = diff;
            var hh = Math.floor(msec / 1000 / 60 / 60);
            msec -= hh * 1000 * 60 * 60;
            var mm = Math.floor(msec / 1000 / 60);
            msec -= mm * 1000 * 60;
            var ss = Math.floor(msec / 1000);
            msec -= ss * 1000;

            var time = mm + (hh * 60);

            if (mm == 0) {
                time = (hh * 60)
            }
            if (hh == 0) {
                time = mm
            }


            return [time, mm, hh]


        },
        // get_time(period) {



        //     for (var i = 0; i < this.period_times.length; i++) {

        //         console.log(this.period_times[i]);

        //         if (this.period_times[i].period_id == period) {

        //             $(`#start_period`).html(`<input id='start_period_time' type='time'  value= ${this.period_times[i].from_time} class='form-control' readonly >`);
        //             $(`#end_period`).html(`<input  id ='end_period_time' type='time' value= ${this.period_times[i].into_time} class='form-control'  readonly><input type='hidden' id ='code' value= ${this.period_times[i].code}>`);
        //             $(`#sort_period`).html(`<input  id ='sort_period_time' type='number' value= ${this.period_times[i].sort_period} class='form-control'  readonly>`);

        //         }

        //     }


        // },
        get_time_for_all_staff(id) {

            axios.post(`/attendance/get_time`, {
                date: this.attendance_date,
                work_system_id: this.work_selected,
                period_id: this.period_selected
            }).then( //get_time_for_current_period
                (response) => {




                    this.value_list = response.data.periods;
                    // console.log(this.value_list);





                });
        },

        get_staff_attendance() {

            axios.post(`/attendance/get_staff_attendance`).then(
                (response) => {


                    this.staff_attendance = response.data.staff_attendance;






                });
        },


        add_one_attendance(period_id,staff_id,index,from,into,sort) {

            this.calc_time(index,from,into);
            this.insert_to_database(index,period_id,staff_id,sort);
            // console.log(this.counts);
            // console.log(this.staff, 'staff');
            // console.log(this.duration, 'duration');
            // console.log(this.delay, 'delay');
            // console.log(this.leave, 'leave');
            // // console.log(this.status,'status');
            // console.log(this.check_in, 'check_in');
            // console.log(this.check_out, 'check_out');
            // console.log(this.attendance_final, 'attendance_final');



        },

        insert_to_database(index,period_id,staff_id,sort) {


            if (this.check_state[index] == true) {

                this.counts[index] = index;
                this.staff[index] = staff_id;
                this.period[index] = period_id;
                this.sort[index] = sort;
                this.duration[index] = $(`#attendance_duration_hidden${index}`).val();
                this.delay[index] = $(`#attendance_delay_hidden${index}`).val();
                this.leave[index] = $(`#attendance_leave_hidden${index}`).val();
                this.extra[index] = $(`#attendance_extra_hidden${index}`).val();
                this.extra_after[index] = $(`#attendance_extra_s_hidden${index}`).val();
                this.check_in[index] = $(`#in${index}`).val();
                this.check_out[index] = $(`#out${index}`).val();

            }
            else if (this.check_state[index] == false) {

                this.$delete(this.counts[index], index);


            }
        },


        get_period(id) {

            // alert(id);
            axios.post(`/attendance/get_period/${id}`).then((response) => {

                // console.log('muhib', response.data);
                this.period_times = response.data.periods
                this.work_types = response.data.work_types
                var arrayLength = response.data.periods.length
                var html = '<option></option>';



                for (var i = 0; i < arrayLength; i++) {

                    html = html + `<option data-period-${id}= ${response.data.periods[i].period_id}   value= ${response.data.periods[i].period_id} >${response.data.periods[i].name} من   ${response.data.periods[i].from_time}  الي ${response.data.periods[i].into_time}</option>`

                }
                // html = html + `<input data-worktype-${id}= ${response.data.work_types.id}   value= ${response.data.work_types.id} >${response.data.work_types.name}  </option>`


                // $(`#select_work_type`).html(`<input id='work_type' type='text'  value= ${this.work_types[0].name} class='form-control' readonly >`);

                $(`#select_period`).html(html);




            });
        },
        // get_search(word_search) {
        //     this.axios
        //         .post(`/staffsearch`, { word_search: this.word_search })
        //         .then(({ data }) => {
        //             this.staffs = data.staffs;


        //         });
        // },

        list(page = 1) {

            this.get_staff_attendance();
            this.axios
                .post(`/attendance?page=${page}`, { type: 'attendance' })
                .then(({ data }) => {

                    this.value_list = data.list;
                    this.staffs = data.staffs;
                    this.work_system_types = data.work_system_types;

                    // this.period_times = data.period_times;
                    // this.period_times = response.data.periods


                })
                .catch(({ response }) => {
                    console.error(response);
                });



        },



    },
};
</script>
