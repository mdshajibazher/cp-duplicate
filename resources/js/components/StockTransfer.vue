<template>
    <modal name="stock-transfer" transition="nice-modal-fade"   height="auto" :draggable="false" :scrollable="true"  :adaptive="true">
        <div style="padding: 40px;" >
            <form @submit.prevent="StockTransferFormSubmit" @keydown="form.onKeydown($event)">
                <AlertError :form="form" />
                <table class="table">
                    <tr>
                        <td>Name:</td>
                        <td>{{ProductData.product_name}}</td>
                    </tr>
                    <tr>
                        <td>Transfer Date</td>
                        <td>
                            <VueDatePicker v-model="form.transferred_at" format="YYYY-MM-DD" placeholder="Choose Date" />
                            <p v-if="form.errors.has('transferred_at')">{{form.errors.get('transferred_at')}}</p>
                        </td>
                    </tr>

                    <tr>
                        <td>Transfer From</td>
                        <td>
                            <select :disabled="readonly_transferred_from" name="warehouse_id" v-model="form.transfer_from" class="form-control" :class="{ 'is-invalid': form.errors.has('transfer_from') }" >
                                <option :value="list.id" v-for="list in transfer_from.warehouses">{{list.name}}</option>
                            </select>
                            <small class="text-danger w-100" v-if="form.errors.has('transfer_from')">{{form.errors.get('transfer_from')}}</small>
                            <p v-if="transfer_from.loading" class="mt-3 text-dark text-black"><i class="fas fa-spinner fa-spin"></i> Loading Stock...</p>
                            <p class="mt-3 mb-0" v-if="transfer_from.loaded">Current Stock {{transfer_from_qty}}</p>
                        </td>

                    </tr>

                    <tr>
                        <td>Transfer To</td>
                        <td>
                            <select :disabled="!form.transfer_from" name="warehouse_id" v-model="form.transfer_to" class="form-control" :class="{ 'is-invalid': form.errors.has('transfer_to') }" >
                                <option :value="list.id" v-for="list in transfer_to.warehouses">{{list.name}}</option>
                            </select>
                            <small class="text-danger w-100" v-if="form.errors.has('transfer_from')">{{form.errors.get('transfer_to')}}</small>

                            <p v-if="transfer_to.loading" class="mt-3 text-dark text-black"><i class="fas fa-spinner fa-spin"></i> Loading Stock...</p>
                            <p class="mt-3 mb-0" v-if="transfer_to.loaded">Current Stock {{transfer_to_qty}}</p>
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
                <div class="d-flex justify-content-between">
                    <p v-if="updateQtyPreview !== '' && form.transfer_from" class="alert alert-warning text-center"><b>"{{getWareHouseByID(form.transfer_from)}}"</b> Stock will be <b>{{parseFloat(transfer_from_qty) - parseFloat(form.qty)}}</b></p>
                    <p v-if="updateQtyPreview !== '' && form.transfer_to" class="alert alert-info text-center"><b>"{{getWareHouseByID(form.transfer_to)}}"</b> Stock will be <b>{{parseFloat(transfer_to_qty) + parseFloat(form.qty)}}</b></p>
                </div>
                <button type="submit" :disabled="form.busy" class="btn btn-success">Change</button>
            </form>
        </div>
    </modal>
</template>

<script>

import Form from 'vform';
import {AlertError} from 'vform/src/components/bootstrap4';

export default {
    name: "StockTransfer",
    props: ['base_url','warehouses'],
    data(){
        return {
            readonly_transferred_from: false,
            ProductData: {"product_name": "","image": ""},
            stock: 0,
            updateQtyPreview: "",
            notes_max_charecter: 10,
            transfer_from:{
                loading: false,
                loaded: false,
                warehouses: [],
            },
            transfer_to:{
                loading: false,
                loaded: false,
                warehouses: [],
            },
            transfer_from_qty: 0,
            transfer_to_qty: 0,
            form: new Form({
                product_id: "",
                qty: "",
                transferred_at: "",
                transfer_from: "",
                transfer_to: "",
                notes: "",
            }),
        }
    },
    components: {
        AlertError,
    },
    watch: {
      "form.transfer_from": function(new_value,old_value) {
          console.log('new_value,old_value',new_value,old_value)
          if(new_value){
              this.getStockByWarehouseAndProductId(new_value,"form.transfer_from")
              this.filterTransferToWarehouseList(new_value);
          }

      },
        "form.transfer_to": function(new_value,old_value) {
            if(new_value){
                this.getStockByWarehouseAndProductId(new_value,"form.transfer_to")
            }

        }
    },
    mounted(){
        this.transfer_from.warehouses = this.warehouses;
        this.transfer_to.warehouses = this.warehouses;
    },
    methods: {
        filterTransferToWarehouseList(id){
            this.transfer_to.warehouses = this.warehouses.filter(wh => wh.id != id);
        },
        getWareHouseByID(id){
          let warehouse = this.warehouses.find(warehouse =>  warehouse.id == id);
          return warehouse.name;
        },
        getStockByWarehouseAndProductId(warehouse_id,transfer_source){
            if(transfer_source === 'form.transfer_from'){
                this.transfer_from.loading = true;
                this.transfer_from.loaded = false;
            }else{
                this.transfer_to.loading = true;
                this.transfer_to.loaded = false;
            }

            let request_payload = {warehouse_id: warehouse_id,product_id: this.ProductData.id }
            axios.post(`${this.base_url}/admin/get_stock_by_warehouse_and_product_id`,request_payload)
            .then(res => {
                if(transfer_source === 'form.transfer_from'){
                    this.transfer_from_qty = res.data;
                }else{
                    this.transfer_to_qty = res.data;
                }
                iziToast.success({
                    title: 'Success',
                    position: 'topRight',
                    message: `Current stock is ${res.data}`,
                });
            })
            .catch(err => {
                iziToast.error({
                    title: 'Error',
                    position: 'topRight',
                    message: err.response.data.message,
                });
            })
            .finally(() => {
                if(transfer_source === 'form.transfer_from'){
                    this.transfer_from.loading = false;
                    this.transfer_from.loaded = true;
                }else{
                    this.transfer_to.loading = false;
                    this.transfer_to.loaded = true;
                }
            })
        },
        StockPreview(){
            if(this.form.qty ==="" || this.form.qty < 1){
                this.form.qty = "";
                this.updateQtyPreview = "";
                return
            }else{
                this.updateQtyPreview = parseInt(this.stock)+ parseInt(this.form.qty);
            }
        },
        StockTransferFormSubmit(){
            this.$Progress.start()
            this.form.busy = true
            this.form.post(this.$parent.base_url+'/admin/transfer_product')
                .then(response => {
                    this.$Progress.finish();
                    this.form.qty = "";
                    iziToast.success({
                        title: 'Success',
                        position: 'topRight',
                        message: 'Stock Transferred Successfully',
                    });

                    this.$emit('regenStock');
                    this.$modal.hide('stock-transfer');

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
