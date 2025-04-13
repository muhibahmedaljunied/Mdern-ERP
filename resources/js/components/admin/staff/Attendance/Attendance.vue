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
                        <div class="card">

                            <div class="card-body">

                                <div class="row">


                                    <div class="col-md-2">
                                        <label for="inputAddress">الفرع</label>
                                        <select style="background-color: beige;" v-model="branchselected"
                                            class="form-control" required>
                                            <option v-for="branch in branches" v-bind:value="branch.id">
                                                {{ branch.name }}
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">

                                        <label for="status"> الهيكل الاداري</label>

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
                              






                                </div>
                                <br>
                                <div class="row">

                                    
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
                                            <option v-for="work_system in work_system_types"
                                                v-bind:value="work_system.id">
                                                {{ work_system.name }}
                                            </option>
                                        </select>




                                    </div>
                                    <div class="col-md-2">
                                        <label for="status"> التأريخ</label>
                                        <input class="form-control" type="date" name="" id="" v-model="attendance_date">


                                    </div>

                                    <div class="col-sm-6 col-md-2" style="margin-top: auto;">


                                        <a @click="get_time_for_all_staff()" href="#">

                                            <i class="fa-solid fa-magnifying-glass fa-xl" style="color: #74C0FC;"></i>


                                        </a>


                                    </div>
                                </div>



                            </div>


                        </div>
                        <div class="card">
                            <div class="card-header">


                                <div style="display: flex;float: left; margin: 5px">

                                    <button @click="exports_excel()">

                                        <i class="fa-solid fa-file-export "
                                            style="font-size: 24px; color: #63E6BE;"></i>
                                    </button>

                                    <button @click="imports_excel()">

                                        <i class="fa-solid fa-file-import "
                                            style="font-size: 24px; color: #B197FC;"></i>
                                    </button>

                                    <input type="search" autocomplete="on" name="search" data-toggle="dropdown"
                                        role="button" aria-haspopup="true" aria-expanded="true" placeholder="بحث "
                                        v-model="word_search" @input="get_search()" />
                                </div>
                            </div>
                            <div class="card-body" id="printme">


                                <form action="post">
                                    <div class="table-responsive">
                                        <table class="table table-bordered text-center" style="font-size: larger;">
                                            <thead>
                                                <tr>
                                                    <th class="wd-10p border-bottom-0">اسم المؤظف</th>

                                                    <th class="wd-10p border-bottom-0">نظام العمل</th>
                                                    <!-- <th class="wd-10p border-bottom-0">الفتره</th> -->


                                                    <th class="wd-5p border-bottom-0">التأريخ</th>

                                                    <th class="wd-5p border-bottom-0">الحاله</th>
                                                    <!-- <th class="wd-5p border-bottom-0">بدايه الفتره</th>
                     <th class="wd-5p border-bottom-0">نهايه الفتره</th> -->
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





                                                    <td>{{ staff.staff_name }}</td>



                                                    <td>{{ staff.name }}</td>

                                                    <!-- <td>


                                                        {{ staff.period_name }}

                                                    </td> -->




                                                    <td v-if="staff.attendance_date">

                                                        {{ attendance_date }}
                                                    </td>

                                                    <td v-else>
                                                        {{ attendance_date }}
                                                    </td>

                                                    <td>

                                                        <span v-if="!staff.period.length" style="color:blue;">

                                                            لم يحضر
                                                        </span>
                                                        <template v-if="staff.period.length">

                                                            <template v-for="attendance in staff.period"
                                                                v-if="attendance.attendance_status == 0">

                                                                <span style="color: red;"> غايب</span>

                                                            </template>

                                                            <template v-else-if="attendance.attendance_status == 1">

                                                                <span>حاضر</span>

                                                            </template>
                                                        </template>


                                                    </td>

                                                    <!-- 
                     <td>


                         <input style="color: red;" type="time" name="in"
                             v-bind:id='"from" + index' v-model="staff.from_time">

                     </td>


                     <td>



                         <input style="color: red;" type="time" name="out"
                             v-bind:id='"into" + index' :value="staff.into_time">

                     </td> -->

                                                    <td>


                                                        <input type="time" name="in" v-bind:id='"in" + index'
                                                            v-model="check_in[index]"
                                                            @change="calc_time(index, staff.from_time, staff.into_time)">

                                                    </td>


                                                    <td>



                                                        <input type="time" name="out" v-bind:id='"out" + index'
                                                            v-model="check_out[index]"
                                                            @change="calc_time(index, staff.from_time, staff.into_time)">

                                                    </td>



                                                    <td>


                                                        <input type="text" class="form-control" name="name"
                                                            v-bind:id='"attendance_duration" + index' disabled />
                                                        <input v-bind:id='"attendance_duration_hidden" + index'
                                                            type="hidden" class="form-control" name="name">


                                                    </td>
                                                    <td>
                                                        <input v-bind:id='"attendance_delay" + index' type="text"
                                                            class="form-control" disabled>
                                                        <input type="hidden"
                                                            v-bind:id='"attendance_delay_hidden" + index'
                                                            class="form-control" name="name">

                                                    </td>
                                                    <td>
                                                        <input v-bind:id='"attendance_leaveout" + index' type="text"
                                                            class="form-control" disabled>
                                                        <input type="hidden"
                                                            v-bind:id='"attendance_leaveout_hidden" + index'
                                                            class="form-control" readonly>

                                                    </td>
                                                    <td>
                                                        <input v-bind:id='"attendance_extra" + index' type="text"
                                                            class="form-control" disabled>
                                                        <input v-bind:id='"attendance_extra_hidden" + index'
                                                            type="hidden" class="form-control">




                                                    </td>

                                                    <td>


                                                        <input v-bind:id='"attendance_extra_s" + index' type="text"
                                                            class="form-control" disabled>
                                                        <input v-bind:id='"attendance_extra_s_hidden" + index'
                                                            type="hidden" class="form-control">

                                                    </td>

                                                    <td>

                                                        <input @change="
                                                            add_one_attendance(
                                                                staff.period_time_id,
                                                                staff.staff_id,
                                                                index,
                                                                staff.from_time,
                                                                staff.into_time,
                                                                staff.sort,


                                                            )
                                                            " type="checkbox" v-model="check_state[index]"
                                                            class="btn btn-info waves-effect" />


                                                    </td>


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
                                <pagination align="center" :data="value_list" @pagination-change-page="list">
                                </pagination>
                            </div>


                        </div>
                    </div>
                </div>

            </div>
        </div>



    </div>
</template>

<script>

import pagination from "laravel-vue-pagination";
import operation from '../../../../staff/operation/operation.js';
import attendance from '../../../../staff/operation/attendance.js';

export default {
    components: {
        pagination,

    },
    mixins: [operation, attendance],

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
            var type = this.get_type_of_leaveout_delay();

            this.axios
                .post(`/store_attendance`, {
                    type: this.type,
                    count: this.counts,
                    staff: this.staff,
                    period: this.period,
                    sort: this.sort,
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
                    leaveout: this.leaveout,
                    extra: this.extra,
                    extra_after: this.extra_after,
                    type_leaveout_delay: type,
                    attendance_in_out: this.attendance_in_out,
                    work: this.work_selected,

                })
                .then((response) => {
                    // console.log(response);
                    toastMessage("تم الاضافه بنجاح");
                    // this.$router.go(0);
                });




        },
        get_type_of_leaveout_delay() {

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



        get_staff_attendance() {

            axios.post(`/attendance/get_staff_attendance`).then(
                (response) => {


                    this.staff_attendance = response.data.staff_attendance;






                });
        },


        add_one_attendance(period_id, staff_id, index, from, into, sort) {

            this.calc_time(index, from, into);
            this.insert_to_database(index, period_id, staff_id, sort);
            // console.log(this.counts);
            // console.log(this.staff, 'staff');
            // console.log(this.duration, 'duration');
            // console.log(this.delay, 'delay');
            // console.log(this.leaveout, 'leaveout');
            // // console.log(this.status,'status');
            // console.log(this.check_in, 'check_in');
            // console.log(this.check_out, 'check_out');
            // console.log(this.attendance_final, 'attendance_final');



        },

        insert_to_database(index, period_id, staff_id, sort) {


            if (this.check_state[index] == true) {

                this.counts[index] = index;
                this.staff[index] = staff_id;
                this.period[index] = period_id;
                this.sort[index] = sort;
                this.duration[index] = $(`#attendance_duration_hidden${index}`).val();
                this.delay[index] = $(`#attendance_delay_hidden${index}`).val();
                this.leaveout[index] = $(`#attendance_leaveout_hidden${index}`).val();
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


            axios.post(`/attendance/get_period/${id}`).then((response) => {


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


        list(page = 1) {

            this.get_staff_attendance();
            this.get_time_for_all_staff();
            this.axios
                .post(`/attendance?page=${page}`, { type: 'attendance' })
                .then(({ data }) => {

                    // this.value_list = data.list;
                    this.staffs = data.staffs;
                    this.work_system_types = data.work_system_types;
                    this.init_attendance(data.list);



                })
                .catch(({ response }) => {
                    console.error(response);
                });



        },

        exports_excel() {

            axios
                .post(`/export_staff`)
                .then(function (response) {

                    toastMessage("تم التصدير");
                    this.list();
                })
                .catch(error => {

                });
        },
        imports_excel() {

            axios
                .post(`/import_staff`)
                .then(function (response) {

                    toastMessage("تم الاستيراد");
                    this.list();

                })
                .catch(error => {

                });
        },





    },
};





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
</script>
