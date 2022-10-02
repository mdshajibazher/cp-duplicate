<template>
    <modal name="stock-adjust" height="auto"  :draggable="true">
        <div style="padding: 40px;" >
    <form @submit.prevent="StockAdjustFormSbumit" @keydown="form.onKeydown($event)">
      <AlertError :form="form" />
  <table class="table">
      <tr>
          <td>Name:</td>
          <td>{{ProductData.product_name}}</td>
      </tr>
       <tr>
          <td>Current Stock:</td>
          <td><h3>{{stock}}</h3></td>
      </tr>
        <tr>
          <td>Adjust Date</td>
          <td>
              <VueDatePicker v-model="form.adjusted_at" format="YYYY-MM-DD" placeholder="Choose Date" />
              <p v-if="form.errors.has('adjusted_at')">{{form.errors.get('adjusted_at')}}</p>
          </td>
      </tr>

      <tr>
          <td>Warehouse</td>
          <td>
              <select name="warehouse_id" v-model="form.warehouse_id" class="form-control" :class="{ 'is-invalid': form.errors.has('warehouse_id') }" >
                  <option :value="list.id" v-for="list in $parent.allWarehouses">{{list.name}}</option>
              </select>
              <small class="text-danger w-100" v-if="form.errors.has('warehouse_id')">{{form.errors.get('warehouse_id')}}</small>
          </td>
      </tr>

      <tr>
          <td>Adjust Type</td>
          <td>
              <select @change="StockPreview();" name="adjust_type" v-model="form.adjust_type" class="form-control" :class="{ 'is-invalid': form.errors.has('adjust_type') }" >
                <option value="increase">Increasing</option>
                <option value="decrease">Decreasing</option>
            </select>
              <small class="text-danger w-100" v-if="form.errors.has('adjust_type')">{{form.errors.get('adjust_type')}}</small>
         </td>
      </tr>
      <tr>
          <td>Qty</td>
          <td>
              <input type="number" @input="StockPreview" name="qty" v-model="form.qty" class="form-control" :class="{ 'is-invalid': form.errors.has('qty') }" placeholder="Enter Adjusted Qty">
          <small class="text-danger w-100" v-if="form.errors.has('qty')">{{form.errors.get('qty')}}</small>
          </td>
      </tr>
      <tr>
          <td>Notes (optional)</td>
          <td>
              <input type="text"  name="notes" v-model="form.notes" class="form-control" :class="{ 'is-invalid': form.errors.has('notes') }" placeholder="Enter Notes">
              <small>Maximum {{notes_max_charecter}} charecter allowed</small>
              <small class="text-danger w-100" v-if="form.errors.has('notes')">{{form.errors.get('notes')}}</small>
          </td>
      </tr>

  </table>
    <h4 v-if="updateQtyPreview !== ''" class="alert alert-warning text-center">New Qty will be <b>{{updateQtyPreview}}</b></h4>
  <button type="submit" :disabled="form.busy" class="btn btn-success">Change</button>
  </form>
        </div>
  </modal>
</template>

<script>

import Form from 'vform';
import { AlertError } from 'vform/src/components/bootstrap4';
export default {
    name: "StockAdjust",

    data(){
        return {
            ProductData: {"product_name": "","image": ""},
            stock: 0,
            updateQtyPreview: "",
            notes_max_charecter: 10,
            form: new Form({
                product_id: "",
                adjust_type: "increase",
                qty: "",
                adjusted_at: "",
                warehouse_id: "",
                notes: "",
            }),
        }
    },
    components: {
        AlertError,
    },
    created(){
      if(this.$parent.warehouse){
          this.form.warehouse_id = this.$parent.warehouse_id;
      }
    },
    methods: {
        StockPreview(){
            if(this.form.qty ==="" || this.form.qty < 1){
                this.form.qty = "";
                this.updateQtyPreview = "";
                return
            }else{
                if(this.form.adjust_type === 'increase'){
                    this.updateQtyPreview = parseInt(this.stock)+ parseInt(this.form.qty);
                }else if(this.form.adjust_type === 'decrease'){
                    this.updateQtyPreview =  parseInt(this.stock)- parseInt(this.form.qty);
                }
            }
        },
        StockAdjustFormSbumit(){
            this.$Progress.start()
            this.form.busy = true
            this.form.post(this.$parent.base_url+'/admin/store_stock_adjustment')
             .then(response => {
                    this.$Progress.finish();
                    this.form.qty = "";
                    iziToast.success({
                        title: 'Success',
                        position: 'topRight',
                        message: response.data.product.product_name +' Stock Adjusted Successfully',
                    });

                this.$emit('regenStock');
                 this.$modal.hide('stock-adjust');

                })
                .catch(e => {
                    console.log(e)
                    iziToast.error({
                            title: 'Error',
                            position: 'topRight',
                            message: e.response.data.message,
                    });
                    this.$Progress.fail()
                })
        }
    }
}
</script>

<style scoped>

</style>
