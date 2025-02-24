<template>
  <!-- row opened -->
  <div class="container-fluid">
    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header">


            <h2>دوام الموظفين</h2>
          </div>


          <div class="card-body" id="printme">
            <div class="row">
              <div class="col-md-2">
                <label for="status">اسم الموظف</label>
                <select @change="select_staff" v-model="staff_selected" name="type" id="type" class="form-control "
                  required>
                  <option v-for="staff in staffs" v-bind:value="staff.id">
                    {{ staff.name }}
                  </option>
                </select>
              </div>
              <div class="col-md-2">
                <label for="status"> نوع الدوام</label>
                <select @change="select_staff" v-model="staff_selected" name="type" id="type" class="form-control "
                  required>
                  <option v-for="staff in staffs" v-bind:value="staff.id">
                    {{ staff.name }}
                  </option>
                </select>
              </div>
              <div class="col-md-2">
                <label for="status">نظام الدوام</label>
                <select @change="select_staff" v-model="staff_selected" name="type" id="type" class="form-control "
                  required>
                  <option v-for="staff in staffs" v-bind:value="staff.id">
                    {{ staff.name }}
                  </option>
                </select>
              </div>
              <!-- <div class="col-md-2">
              <label for="status">الفتره</label>
              <select @change="select_staff" v-model="staff_selected" name="type" id="type" class="form-control " required>
                <option v-for="staff in staffs" v-bind:value="staff.id">
                  {{ staff.name }}
                </option>
              </select>
            </div> -->
              <!-- <div class="col-md-2">
              <label for="status"> من تأريخ</label>
             <input v-model="from_date" type="date" name="" id="" class="form-control">
            </div>

            <div class="col-md-2">
              <label for="status">الي تأريخ</label>
              <input v-model="from_date" type="date" name="" id="" class="form-control">
            </div> -->




              <div class="col-sm-6 col-md-2" style="margin-top: auto;">


                  <a @click="report()" href="#">


                  <i class="fa-solid fa-magnifying-glass fa-2xl" style="color: #74C0FC;"></i>


                </a>


              </div>



            </div>

          </div>
        </div>
        <!--/div-->
      </div>
      <div class="row row-sm">
        <div class="col-xl-12">
          <div class="card">



            <div class="card-body" id="printme">
              <div class="row">

                <div class="table-responsive">
                  <table class="table table-bordered text-center">
                    <thead>
                      <tr>

                        <th class="wd-15p border-bottom-0">اسم المؤظف</th>
                        <th class="wd-15p border-bottom-0">التاريخ</th>

                        <th class="wd-15p border-bottom-0"> نوع الخصم</th>
                        <th class="wd-15p border-bottom-0">قيمه الخصم</th>

                        <th class="wd-15p border-bottom-0" style="color:red"> الاجمالي</th>


                      </tr>
                    </thead>
                    <tbody v-if="list_data && list_data.data.length > 0">
                      <tr v-for="(discount, index) in list_data.data" :key="index">
                        <td>{{ discount.name }}</td>
                        <td>{{ discount.date }}</td>

                        <td>

                          <div v-for="(discount_names, index) in discount.discount" :key="index">
                            {{ discount_names.discount_type.name }}
                          </div>
                        </td>

                        <td>

                          <div v-for="(discount_qty, index) in discount.discount" :key="index">
                            {{ discount_qty.quantity }}
                          </div>
                        </td>

                        <td style="color:red">{{ discount.sum_discount }}</td>

                      </tr>
                      <tr>
                        <td colspan="4" style="color:red;font-size: x-large;">الاجمالي</td>

                      </tr>
                    </tbody>
                    <tbody v-else>
                      <tr>
                        <td align="center" colspan="3">لايوجد بياتات.</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <pagination align="center" :data="discounts" @pagination-change-page="list"></pagination>
              </div>





            </div>

          </div>
        </div>
        <!--/div-->
      </div>
    </div>

    </div>
    <!-- /row -->
</template>

<script>
import pagination from "laravel-vue-pagination";
import operation from '../../../../staff/StaffData/staff_data.js';

export default {
  components: {
    pagination,
  },
  mixins: [operation],
  data() {
    return {
      discount_types: "",
      staffs: '',
      staffselected: '',
      typeselected: '',
      date: '',
      quantity: '',
      staff_selected: 1,
      note: '',
      name: '',
      table: 'discount',
      list_data: {
        type: Object,
        default: null,
      },
      from_date: new Date().toISOString().substr(0, 10),
      into_date: new Date().toISOString().substr(0, 10),
      word_search: "",
    };
  },
  mounted() {
    this.list();
    this.type = 'discount';
  },
  methods: {






    report() {
      this.axios
        .post(`/work_system_report`, {
          type: this.type,
          staff: this.staff_selected,
          from_date: this.from_date,
          into_date: this.into_date,
        })
        .then(({ data }) => {
          this.list_data = data.list;

        });
    },

    list(page = 1) {
      this.axios
        .post(`/discount?page=${page}`)
        .then(({ data }) => {
          this.list_data = data.list;
          this.discount_types = data.discount_types;
          this.staffs = data.staffs;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },

  },
};
</script>
