<template>
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header pb-0">

          <span class="h2">تفاصيل مرتجع التوريد</span>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table text-md-nowrap" id="example1">
              <thead>
                <tr>
                  <!-- <th class="wd-15p border-bottom-0">رقم المرتجع</th> -->
                  <th class="wd-15p border-bottom-0">المنتج</th>
                  <th class="wd-15p border-bottom-0">الحاله</th>
                  <th class="wd-15p border-bottom-0"> الكميه المرتجعه</th>
                  <th class="wd-15p border-bottom-0">المخزن</th>



                </tr>
              </thead>
              <tbody>
                <tr v-for="return_details in return_detail">
                  <!-- <td>{{ return_details.supply_return_id }}</td> -->
                  <td>{{ return_details.product }}</td>
                  <td>{{ return_details.status }}</td>
                  <td>{{ return_details.qty_return }}</td>
                  <td>{{ return_details.store }}</td>






                </tr>
                <!-- <a 
                      @click="$router.go(-1)"
                      class="btn btn-success"
                      ><span> تراجع</span></a
                    > -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>


</template>
<script>
export default {
  data() {
    return {
      return_detail: "yes",
    };
  },
  mounted() {

    let uri = `/returnpurchase_details/${this.$route.params.id}`;
    this.axios.post(uri, { id: this.$route.params.id }).then((response) => {

      this.return_detail = response.data.return_details;

    });
  }
};
</script>
