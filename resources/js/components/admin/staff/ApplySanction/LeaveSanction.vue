<template>


    <div class="content container-fluid">



        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            <span class="h4">تطبيق لوائح الانصراف</span>
                        </div>

                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-2">
                                <label for="status"> نوع الانصراف</label>

                                <select v-model="leaveoutselected" name="type" class="form-control " required>
                                    <option v-for="leaveout in leaveout_types"
                                        v-bind:value="[leaveout.id, leaveout.code]">
                                        {{ leaveout.name }}
                                    </option>
                                </select>

                            </div>

                            <div class="col-md-2">
                                <label for="status">المده</label>
                                <select v-model="leaveout_part_selected" class="form-control " required>
                                    <option v-for="leaveout_part in leaveout_parts"
                                        v-bind:value="[leaveout_part.id, leaveout_part.duration]">
                                        {{ leaveout_part.name }}
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
                            <!-- <div class="col-md-2">
                                <label for="status"> عدد المرات</label>
                                <select v-model="iterationselected" name="type"
                                    class="form-control " required>
                                    <option v-for="iteration in iterations" v-bind:value="iteration.id">
                                        {{ iteration.name }}
                                    </option>
                                </select>




                            </div> -->




                            <div class="col-sm-6 col-md-2" style="margin-top: auto;">

                                <a @click="search()" id="agregar_productos" data-target=".bs-example-modal-sm">
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

                                            <th class="wd-10p border-bottom-0">اسم المؤظف</th>
                                            <th class="wd-10p border-bottom-0">نوع الانصراف</th>
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

                                            <td v-for="leaveout in leaveout_types"
                                                v-if="leaveout.code == leaveoutselected[1]">


                                                {{ leaveout.name }}
                                            </td>

                                            <td v-for="part in leaveout_parts"
                                                v-if="part.id == leaveout_part_selected[0]">

                                                {{ part.name }}

                                            </td>
                                            <td>{{ staff.attendance }}</td>


                                            <td>
                                                <span class="badge bg-danger" v-if="staff.leaveout.length"> ضمن
                                                    اللائحه</span>
                                                <span class="badge bg-success" v-else>ليس ضمن اللائحه</span>
                                            </td>



                                            <td>

                                                <template v-if="staff.leaveout.length">
                                                    <button type="button" data-toggle="modal"
                                                        class="tn btn-success btn-sm waves-effect btn-agregar"
                                                        :data-target="'#addDelay' + indexs"> فحص
                                                        اللائحه</button>


                                                    <button data-toggle="tooltip"
                                                        class="tn btn-success btn-sm waves-effect btn-agregar">
                                                        تطبيق</button>




                                                    <div class="modal fade bs-example-modal-lg" tabindex="-1"
                                                        role="dialog" aria-labelledby="myLargeModalLabel"
                                                        aria-hidden="true" style="display: none"
                                                        :id="'addDelay' + indexs">
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

                                                                                                        <th> نوع
                                                                                                            الانصراف
                                                                                                        </th>
                                                                                                        <th> نوع
                                                                                                            الخصم
                                                                                                        </th>


                                                                                                        <th>
                                                                                                            عدد المرات
                                                                                                        </th>
                                                                                                        <th> قيمه
                                                                                                            الخصم
                                                                                                        </th>




                                                                                                        <th>اضافه
                                                                                                        </th>
                                                                                                    </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                    <tr v-for="(leaveout, index_leaveout) in staff.leaveout"
                                                                                                        :key="index_leaveout">
                                                                                                        <td>

                                                                                                            {{
                                                                                                                leaveout.leaveout_name
                                                                                                            }}
                                                                                                        </td>
                                                                                                        <td>

                                                                                                            {{
                                                                                                                leaveout.name
                                                                                                            }}
                                                                                                        </td>

                                                                                                        <td>

                                                                                                            {{
                                                                                                                leaveout.iteration
                                                                                                            }}
                                                                                                        </td>

                                                                                                        <td>

                                                                                                            {{
                                                                                                                leaveout.sanction
                                                                                                            }}
                                                                                                        </td>



                                                                                                        <td>


                                                                                                            <input
                                                                                                                @change="
                                                                                                                    check_row(


                                                                                                                    index_leaveout
                                                                                                                    )
                                                                                                                    "
                                                                                                                type="checkbox"
                                                                                                                v-model="check_state[index_leaveout]"
                                                                                                                class="btn btn-info waves-effect" />

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
                                                <template v-else>

                                                    <span>لايوجد</span>

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

            leaveout_part_selected: [],
            leaveout_types: '',
            leaveout_parts: '',
            leaveoutselected: [],



        };
    },
    mounted() {
        this.list();
        this.type = 'attendance';
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
                .post(`/leaveout_sanction?page=${page}`)
                .then(({ data }) => {
                    this.leaveout_types = data.leaveout_types;
                    this.leaveout_parts = data.leaveout_parts;
                    this.staffs = data.staffs;

                    this.value_list = data.list;
                })
                .catch(({ response }) => {
                    console.error(response);
                });
        },


        search() {

            axios.post(`/leaveout_sanction_attendance`, {
                leaveout_type_code: this.leaveoutselected[1],
                leaveout_type_id: this.leaveoutselected[0],
                leaveout_part_duration: this.leaveout_part_selected[1],
                leaveout_part_id: this.leaveout_part_selected[0],
                staff_id: this.staffselected,


            }).then(
                (response) => {

                    this.value_list = response.data.list;

                });
        },



    },
};
</script>
