<template>


    <div class="content container-fluid">



        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            <span class="h4">تطبيق لوائح التأخير</span>
                        </div>

                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-2">
                                <label for="status"> نوع التأخير</label>

                                <select v-model="delayselected" name="type" class="form-control " required>
                                    <option v-for="delay in delay_types" v-bind:value="[delay.id, delay.code]">
                                        {{ delay.name }}
                                    </option>
                                </select>

                            </div>

                            <div class="col-md-2">
                                <label for="status">المده</label>
                                <select v-model="delay_part_selected" class="form-control " required>
                                    <option v-for="delay_part in delay_parts"
                                        v-bind:value="[delay_part.id, delay_part.duration]">
                                        {{ delay_part.name }}
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
                            <div class="col-sm-6 col-md-2" style="margin-top: auto;">


                                <a @click="search()" id="agregar_productos" data-target=".bs-example-modal-sm">
                                    <img src="/assets/img/search.png" alt="" style="width: 15%;"></a>
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


                                <!-- <a @click="get_staff_attendance(period_selected)" id="agregar_productos"
                                    data-target=".bs-example-modal-sm">
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

                                            <th class="wd-10p border-bottom-0">اسم المؤظف</th>
                                            <th class="wd-10p border-bottom-0">نوع التأخير</th>
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

                                            <td v-for="delay in delay_types" v-if="delay.code == delayselected[1]">


                                                {{ delay.name }}
                                            </td>

                                            <td v-for="part in delay_parts" v-if="part.id == delay_part_selected[0]">

                                                {{ part.name }}

                                            </td>
                                            <td>{{ staff.attendance }}</td>

                                            <td>
                                                <span class="badge bg-danger" v-if="staff.delay.length"> ضمن
                                                    اللائحه</span>
                                                <span class="badge bg-success" v-else>ليس ضمن اللائحه</span>
                                            </td>



                                            <td>

                                                <template v-if="staff.delay.length">
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
                                                                                                            التأخير
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
                                                                                                    <tr v-for="(delay, index_delay) in staff.delay"
                                                                                                        :key="index_delay">
                                                                                                        <td>

                                                                                                            {{
                                                                                                                delay.delay_name
                                                                                                            }}
                                                                                                        </td>
                                                                                                        <td>

                                                                                                            {{
                                                                                                                delay.name
                                                                                                            }}
                                                                                                        </td>

                                                                                                        <td>

                                                                                                            {{
                                                                                                                delay.iteration
                                                                                                            }}
                                                                                                        </td>

                                                                                                        <td>

                                                                                                            {{
                                                                                                                delay.sanction
                                                                                                            }}
                                                                                                        </td>



                                                                                                        <td>


                                                                                                            <input
                                                                                                                @change="
                                                                                                                    check_row(

                                                                                                                    index_delay

                                                                                                                    )
                                                                                                                    "
                                                                                                                type="checkbox"
                                                                                                                v-model="check_state[index_delay]"
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


            delay_part_selected: [],
            delay_types: '',
            delay_parts: '',
            delayselected: [],









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
                .post(`/delay_sanction?page=${page}`)
                .then(({ data }) => {

                    this.delay_types = data.delay_types;
                    this.delay_parts = data.delay_parts;
                    this.staffs = data.staffs;

                    this.value_list = data.list;

                })
                .catch(({ response }) => {
                    console.error(response);
                });
        },

        search() {

            axios.post(`/delay_sanction_attendance`, {
                delay_type_code: this.delayselected[1],
                delay_type_id: this.delayselected[0],
                delay_part_duration: this.delay_part_selected[1],
                delay_part_id: this.delay_part_selected[0],
                staff_id: this.staffselected,


            }).then(
                (response) => {

                    this.value_list = response.data.list;

                });
        },



    },
};
</script>
