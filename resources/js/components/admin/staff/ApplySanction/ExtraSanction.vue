<template>


    <div class="content container-fluid">



        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            <span class="h4">تطبيق لوائح الاضافي</span>
                        </div>

                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-2">
                                <label for="status"> نوع الاضافي</label>

                                <select v-model="extraselected" name="type" class="form-control " required>
                                    <option v-for="extra_type in extra_types"
                                        v-bind:value="[extra_type.id, extra_type.code]">
                                        {{ extra_type.name }}
                                    </option>
                                </select>

                            </div>

                            <div class="col-md-2">
                                <label for="status">المده</label>
                                <select v-model="extra_part_selected" class="form-control " required>
                                    <option v-for="extra_part in extra_parts"
                                        v-bind:value="[extra_part.id, extra_part.duration]">
                                        {{ extra_part.name }}
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
                                <label for="status"> عدد المرات</label>
                                <select v-model="iterationselected" name="type" class="form-control " required>
                                    <option v-for="iteration in iterations" v-bind:value="iteration.id">
                                        {{ iteration.name }}
                                    </option>
                                </select>




                            </div> -->




                            <div class="col-sm-6 col-md-2" style="margin-top: auto;">


<!-- 
                                <a @click="search()" id="agregar_productos" data-target=".bs-example-modal-sm">
                                    <img src="/assets/img/search.png" alt="" style="width: 15%;"></a> -->

                                    <a href="#" @click="search()"> <i class="fa-solid fa-magnifying-glass fa-xl" style="color: #74C0FC;"></i></a>
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

                                            <th class="wd-10p border-bottom-0">اسم المؤظف</th>
                                            <th class="wd-10p border-bottom-0">نوع الاضافي</th>
                                            <th class="wd-10p border-bottom-0">المده</th>
                                            <th class="wd-10p border-bottom-0">عدد المرات</th>

                                            <th class="wd-10p border-bottom-0"> الحاله</th>

                                            <th class="wd-10p border-bottom-0"> اللائحه </th>




                                        </tr>
                                    </thead>
                                    <tbody v-if="value_list && value_list.data.length > 0">
                                        <tr v-for="(staff, indexs) in value_list.data" :key="indexs"
                                            v-if="staff.attendance > 0">



                                            <td>{{ staff.name }}</td>

                                            <td v-for="extra in extra_types" v-if="extra.code == extraselected[1]">


                                                {{ extra.name }}
                                            </td>

                                            <td v-for="part in extra_parts" v-if="part.id == extra_part_selected[0]">

                                                {{ part.name }}

                                            </td>
                                            <td>{{ staff.attendance }}</td>



                                            <td>
                                                <span class="badge bg-danger" v-if="staff.extra">

                                                    ضمن
                                                    اللائحه


                                                </span>


                                                <span v-if="staff.staff_sanction">
                                                    <span class='badge bg-info'> تم تطبيق اللائحه</span>
                                                </span>


                                                <span v-if="!staff.staff_sanction && !staff.extra">
                                                    <span class='badge bg-success'> ليس ضمن اللائحه</span>
                                                </span>

                                            </td>







                                            <td>




                                                <template v-if="staff.extra">



                                                    <button type="button" data-toggle="modal"
                                                        class="tn btn-success btn-sm waves-effect btn-agregar"
                                                        :data-target="'#addAbsence' + indexs"> فحص
                                                        اللائحه</button>



                                                    <button type="button" @click="apply(staff.extra, staff.staff_id)"
                                                        data-toggle="tooltip"
                                                        class="tn btn-success btn-sm waves-effect btn-agregar">
                                                        تطبيق</button>






                                                    <div class="modal fade bs-example-modal-lg" tabindex="-1"
                                                        role="dialog" aria-labelledby="myLargeModalLabel"
                                                        aria-hidden="true" style="display: none"
                                                        :id="'addAbsence' + indexs">
                                                        <div class="modal-dialog modal-lg" style="width: 100%">
                                                            <div class="modal-content">
                                                                <!-- <div class="modal-header">


<div class="col-md-4">
<div class="col-sm-12">
<input type="text" placeholder="بحث"
class="form-control" name="buscar_producto"
id="buscar_producto" v-model="word_search"
@input="get_search()" />
</div>
</div>
</div> -->
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

                                                                                                        <th> نوع
                                                                                                            التأخير
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
                                                                                                    v-if="staff.extra">
                                                                                                    <tr v-for="(extra, index_extra) in staff.extra"
                                                                                                        :key="index_extra">

                                                                                                        <td>

                                                                                                            {{
                                                                                                                extra.extra_name
                                                                                                            }}
                                                                                                        </td>
                                                                                                        <td>

                                                                                                            {{
                                                                                                                extra.name
                                                                                                            }}
                                                                                                        </td>

                                                                                                        <td>

                                                                                                            {{
                                                                                                                extra.iteration
                                                                                                            }}
                                                                                                        </td>

                                                                                                        <td>

                                                                                                            {{
                                                                                                                extra.sanction
                                                                                                            }}
                                                                                                        </td>



                                                                                                        <td>


                                                                                                            <input
                                                                                                                @change="
                                                                                                                    check_row(

                                                                                                                        index_extra

                                                                                                                    )
                                                                                                                    "
                                                                                                                type="checkbox"
                                                                                                                v-model="check_state[index_extra]"
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

            extra_types: '',
            extra_parts: '',
            extraselected: [],
            extra_part_selected: [],

        };
    },
    mounted() {
        this.list();
        this.type = 'extra';
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
                .post(`/extra_sanction?page=${page}`)
                .then(({ data }) => {

                    this.value_list = data.list;
                    this.extra_types = data.extra_types;
                    this.staffs = data.staffs;

                    this.extra_parts = data.extra_parts;


                })
                .catch(({ response }) => {
                    console.error(response);
                });
        },



        search() {

            axios.post(`/extra_sanction_attendance`, {
                extra_type_code: this.extraselected[1],
                extra_type_id: this.extraselected[0],
                extra_part_duration: this.extra_part_selected[1],
                extra_part_id: this.extra_part_selected[0],
                staff_id: this.staffselected,
                date: this.dateselected,


            }).then(
                (response) => {

                    this.value_list = response.data.list;

                });
        },


    },
};
</script>
