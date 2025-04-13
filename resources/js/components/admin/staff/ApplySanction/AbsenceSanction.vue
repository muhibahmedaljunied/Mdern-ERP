<template>


    <div class="content container-fluid">



        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            <span class="h4">تطبيق لوائح الغياب</span>
                        </div>

                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-2">
                                <label for="status"> نوع الغياب</label>

                                <select v-model="absenceselected" name="type" class="form-control " required>
                                    <option v-for="absence in absence_types" v-bind:value="[absence.id, absence.code]">
                                        {{ absence.name }}
                                    </option>
                                </select>

                            </div>
                            <div class="col-md-2">
                                <label for="status"> الموظف</label>

                                <select v-model="staffselected" name="type" class="form-control " required>
                                    <option v-for="staff in staffs" v-bind:value="staff.id">
                                        {{ staff.name }}
                                    </option>
                                </select>

                            </div>


                            <div class="col-md-2">
                                <label for="status"> التأريخ</label>
                                <input class="form-control" type="date" name="" id="" v-model="dateselected">


                            </div>


                            <!-- <div class="col-md-2">
                                <label for="status">عدد المرات</label>
                                <select v-model="iterationselected" class="form-control " required>
                                    <option v-for="iteration in iterations" v-bind:value="iteration.id">
                                        {{ iteration.name }}
                                    </option>
                                </select>
                            </div> -->
                            <!-- <div class="col-md-2">
                                <label for="status">نظام العمل</label>
                                <select @change="get_period(work_selected)" v-model="work_selected" name="type"
                                    class="form-control " required>
                                    <option v-for="work_system in work_system_types" v-bind:value="work_system.id">
                                        {{ work_system.name }}
                                    </option>
                                </select>




                            </div> -->

                            <!--<div class="col-md-2">
                                <label for="status"> الفتره</label>
                                <select id='select_period' v-model="period_selected" name="type" class="form-control "
                                    required>

                                </select>
                            </div> -->

                            <!-- <div class="col-md-2">
                                <label for="status"> التأريخ</label>
                                <input class="form-control" type="date" name="" id="" v-model="apply_date">


                            </div> -->

                            <div class="col-sm-6 col-md-2" style="margin-top: auto;">
                                <!-- <input type="search" autocomplete="on" name="search" data-toggle="dropdown"
                                        role="button" aria-haspopup="true" aria-expanded="true" placeholder="بحث "
                                        v-model="word_search"   />
 -->

                                        <a href="#" @click="search()"> <i class="fa-solid fa-magnifying-glass fa-xl" style="color: #74C0FC;"></i></a>

                                <!-- <a @click="search()" id="agregar_productos" data-target=".bs-example-modal-sm">
                                    <img src="/assets/img/search.png" alt="" style="width: 15%;"></a> -->
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
                                            <th class="wd-10p border-bottom-0">الرقم التسلسلي</th>
                                            <th class="wd-10p border-bottom-0">اسم المؤظف</th>
                                            <th class="wd-10p border-bottom-0">نوع الغياب</th>
                                            <th class="wd-10p border-bottom-0">عدد المرات</th>

                                            <th class="wd-10p border-bottom-0">الحاله</th>
                                            <th class="wd-10p border-bottom-0"> اللائحه </th>




                                        </tr>
                                    </thead>
                                    <tbody v-if="value_list && value_list.data.length > 0">
                                        <tr v-for="(staff, indexs) in value_list.data" :key="indexs"
                                            v-if="staff.attendance > 0">

<td>
    {{ indexs+1 }}
</td>

                                            <td>{{ staff.name }}</td>

                                            <td v-for="absence in absence_types"
                                                v-if="absence.code == absenceselected[1]">


                                                {{ absence.name }}
                                            </td>


                                            <td>{{ staff.attendance }}</td>



                                            <td>
                                                <span v-if="staff.absence">

                                                    <!-- <span v-for="sanctions in staff.absence"> -->
                                                    <!-- 
                                                        <span v-if="sanctions.staff_sanction.length > 0">

                                                            <span v-for="staff_sanction in sanctions.staff_sanction"> -->

                                                    <span class = 'badge bg-danger'> ضمن اللائحه</span>


                                                    <!-- </span> -->



                                                    <!-- </span> -->



                                                    <!-- </span> -->
                                                </span>

                                                <span  v-if="staff.staff_sanction">

                                                    <span class = 'badge bg-success'> تم تطبيق اللائحه</span>
                                                </span>

                                                
                                                <span v-if="!staff.staff_sanction && !staff.absence" >
                                                    <span class='badge bg-success'>   ليس ضمن اللائحه</span>
                                                </span>

                                            </td>


                                            <td>




                                                <template v-if="staff.absence">

                                                    <button type="button" data-toggle="modal"
                                                        class="tn btn-success btn-sm waves-effect btn-agregar"
                                                        :data-target="'#addAbsence' + indexs"> فحص
                                                        اللائحه</button>


                                                    <button type="button" @click="apply(staff.absence, staff.staff_id)"
                                                        data-toggle="tooltip"
                                                        class="tn btn-success btn-sm waves-effect btn-agregar">
                                                        تطبيق</button>


                                                    <div class="modal fade bs-example-modal-lg" tabindex="-1"
                                                        role="dialog" aria-labelledby="myLargeModalLabel"
                                                        aria-hidden="true" style="display: none"
                                                        :id="'addAbsence' + indexs">
                                                        <div class="modal-dialog modal-lg" style="width: 100%">
                                                            <div class="modal-content">

                                                                <div class="modal-body">
                                                                    <div class="row row-sm">
                                                                        <div class="col-xl-12">
                                                                            <div class="card">

                                                                                <div class="card-body">
                                                                                    <form method="post">

                                                                                        <div class="table-responsive">
                                                                                            <table
                                                                                                class="table table-bordered text-right"
                                                                                                style="width: 100%; font-size: x-large">
                                                                                                <thead>
                                                                                                    <tr>
                                                                                                        <th >الرقم التسلسلي</th>

                                                                                                        <th> نوع
                                                                                                            الغياب
                                                                                                        </th>
                                                                                                        <th> نوع
                                                                                                            الخصم
                                                                                                        </th>


                                                                                                        <th>
                                                                                                            عدد
                                                                                                            المرات
                                                                                                        </th>
                                                                                                        <th> قيمه
                                                                                                            الخصم
                                                                                                        </th>




                                                                                                        <th>اضافه
                                                                                                        </th>
                                                                                                    </tr>
                                                                                                </thead>
                                                                                                <tbody
                                                                                                    v-if="staff.absence">
                                                                                                    <tr v-for="(absence, index_absence) in staff.absence"
                                                                                                        :key="index_absence">

                                                                                                        <td>
                                                                                                            {{ index_absence+1 }}
                                                                                                        </td>
                                                                                                        <td>

                                                                                                            {{
                                                                                                                absence.absence_name
                                                                                                            }}
                                                                                                        </td>
                                                                                                        <td>

                                                                                                            {{
                                                                                                                absence.name
                                                                                                            }}
                                                                                                        </td>

                                                                                                        <td>

                                                                                                            {{
                                                                                                                absence.iteration
                                                                                                            }}
                                                                                                        </td>

                                                                                                        <td>

                                                                                                            {{
                                                                                                                absence.sanction
                                                                                                            }}
                                                                                                        </td>



                                                                                                        <td>


                                                                                                            <input
                                                                                                                @change="
                                                                                                                    check_row(

                                                                                                                        index_absence

                                                                                                                    )
                                                                                                                    "
                                                                                                                type="checkbox"
                                                                                                                v-model="check_state[index_absence]"
                                                                                                                class="btn btn-info waves-effect" />

                                                                                                        </td>



                                                                                                    </tr>

                                                                                                </tbody>
                                                                                                <tbody v-else>
                                                                                                    <tr>

                                                                                                        <td colspan="4">
                                                                                                            لايوجد
                                                                                                            بيانات
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </tbody>

                                                                                            </table>
                                                                                        </div>
                                                                                    </form>

                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-primary"
                                                                        @click="Add_new()">حفظ </button>
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>

                                                                </div>


                                                            </div>

                                                        </div>


                                                    </div>

                                                </template>

                                                










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
                            <!-- <a href="javascript:void" @click="Add_new()" class="btn btn-success"><span>تاكيد
                  العمليه</span></a> -->
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
            absence_types: '',
            absenceselected: [],
           

        };
    },
    mounted() {
        this.list();
        this.type = 'absence';
    },
    methods: {

        check_row(index) {


            if (this.check_state[index] == true) {

                this.counts[index] = index;
                // this.staff[index] = staff_id;
                // this.period[index] = period_id;

            }
            else if (this.check_state[index] == false) {

                this.$delete(this.counts[index], index);


            }

        },
        list(page = 1) {
            this.axios
                .post(`/absence_sanction?page=${page}`)
                .then(({ data }) => {


                    this.absence_types = data.absence_types;
                    this.iteration = data.iteration;
                    this.staffs = data.staffs;
                    this.value_list = data.list;
                })
                .catch(({ response }) => {
                    console.error(response);
                });
        },
        search() {

            axios.post(`/absence_sanction_attendance`, {
                absence_type_code: this.absenceselected[1],
                absence_type_id: this.absenceselected[0],
                date: this.dateselected,
                staff_id: this.staffselected,


            }).then(
                (response) => {

                    this.value_list = response.data.list;



                });
        },

    },
};
</script>
