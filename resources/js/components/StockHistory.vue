<template>
    <modal name="stock-history" transition="nice-modal-fade"   height="auto" :draggable="false" :scrollable="true"  :adaptive="true">
        <div style="padding: 20px;cursor: move">
            <div class="row justify-content-end">
                <div class="col-6">
                    <h5>"{{ $parent.currentProductData.product_name }}" History </h5>
                </div>
                <div class="col-6">
                    <div class="w-100 text-right">
                        <button @click="hide()" type="button" class="btn btn-danger rounded-circle">X</button>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-9">
                    <div class="form-group">
                        <p class="text-dark mb-2">Per Page</p>
                        <select v-model="$parent.history_per_page" class="form-control" style="width: 100px" @change="$parent.showStockHistory(1,false)">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="40">40</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <img class="img-thumbnail ml-3 w-100" style="width: 100px"
                         :src="$parent.base_url+'/public/uploads/products/tiny/'+$parent.currentProductData.image" alt="">
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <pagination :limit="2" :data="$parent.StockHistoryData"
                                @pagination-change-page="paginationDataHandling"></pagination>
                </div>
            </div>
            <div class="tbl-height">
            <table class="table table-bordered table-striped">
                <tr>
                    <td>Date</td>
                    <td>Type</td>
                    <td>Qty</td>
                </tr>
                <tr v-for="(history,index) in $parent.StockHistoryData.data" :key="index">
                    <td class="align-middle">{{ new Date(history.date) | moment("D-MMM-YYYY") }} <br>
                        <small>{{ history.warehouse_name}}</small>
                    </td>
                    <td class="align-middle"><span class="badge"
                                                   :class="getBadgeOrCurrencySign(history)">  {{
                            getModifiedStockHistory(history)
                        }}</span>
                        <br>
                        <div v-if="history.type === 'Stock Transfer'">
                            <small> ( {{history.qty > 0 ? 'Get From ' : 'Transfer To'  }} <br> {{getWareHouseName(history.transfer_from_warehouse_id)}} )</small>
                        </div>
                        <small class="text-primary">Notes: {{ history.notes }}</small>
                        <div v-if="history.type === 'Stock Adjustments' && history.editable == true" class="mt-3">
                            <div class="form-group">
                                <VueDatePicker v-model="adjustMent.adjusted_at" format="YYYY-MM-DD" placeholder="Choose Date" />
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Qty" v-model="adjustMent.qty">
                            </div>
                            <div class="form-group">
                                <select class="form-control" v-model="adjustMent.warehouse_id">
                                    <option v-for="wh in $parent.allWarehouses"  :value="wh.id">
                                        {{ wh.name }}
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" :class="{ 'is-invalid': adjustMent.errors.has('notes') }" class="form-control" placeholder="Enter Notes" v-model="adjustMent.notes">
                                <small class="text-danger w-100" v-if="adjustMent.errors.has('notes')">{{adjustMent.errors.get('notes')}}</small>
                            </div>
                            <div class="form-group d-flex justify-content-between">
                                <button :disabled="history_update_loader" @click="updateAdjustMent(index,history.id)"
                                        type="button" class="btn btn-primary btn-sm"><span v-if="history_update_loader">Please wait...</span>
                                    <span v-else> <i
                                        class="fas fa-check-circle"></i> update</span></button>
                                <button @click="history.editable = false;$parent.adjustMent={id: null, qty: null}"
                                        type="button" class="btn btn-danger btn-sm"><i
                                    class="fas fa-times"></i> Close
                                </button>
                            </div>
                        </div>

                    </td>
                    <th class="align-middle">{{ getBadgeOrCurrencySign(history, 'sign') }}
                        <button v-if="auth_user_permissions.includes('stock.edit') && history.type === 'Stock Adjustments' && history.editable == false"
                                @click="openAdjustForm(index)" type="button" class="btn btn-link">(Edit)
                        </button>
                    </th>
                </tr>
            </table>
            </div>
        </div>
    </modal>
</template>

<script>
import Form from 'vform';
export default {
    name: "StockHistory",
    props: ['auth_user_permissions','warehouses'],
    data() {
        return {
            history_update_loader: false,
            adjustMent: new Form( {
                adjusted_at: '',
                id: null,
                qty: null,
                warehouse_id: null,
                notes: '',
            }),
        }
    },
    methods: {
        hide () {
            this.$modal.hide('stock-history');
        },
        getWareHouseName(wh_id){
          return this.warehouses.find(wh => wh.id == wh_id).name;
        },
        getModifiedStockHistory(history) {
            console.log('history',history)
            if (history.type === 'Stock Adjustments') {
                return parseInt(history.qty) < 0 ? 'Stock Decrease' : 'Stock Increase';
            }
            // else if(history.type === 'Stock Transfer'){
            //     return `${history.type} from ${history.warehouse_name}` ;
            // }
            return history.type;
        },
        paginationDataHandling(page=1){
            this.$parent.showStockHistory(page,false);
        },
        updateAdjustMent(index, column_id) {
            this.history_update_loader = true;
            let wh_id = this.adjustMent.warehouse_id;
            let params = {
                'adjusted_at': this.adjustMent.adjusted_at,
                'warehouse_id': wh_id,
                'qty': this.adjustMent.qty,
                'notes': this.adjustMent.notes
            };
            this.$Progress.start();
            this.adjustMent.post(`${this.$parent.base_url}/admin/update_adjust/${column_id}`, params)
                .then((res) => {
                    iziToast.success({
                        title: 'Success',
                        position: 'topRight',
                        message: 'Adjustment updated successfully',
                    });
                    this.$Progress.finish();
                    this.$parent.getData();
                    this.$parent.showStockHistory();
                    this.$modal.hide('stock-history');
                })
                .catch(err => {
                    iziToast.error({
                        title: 'Error',
                        position: 'topRight',
                        message: err.response.data.message,
                    });
                    this.$Progress.fail();
                })
                .finally(() => {
                    this.history_update_loader = false;
                })
        },
        openAdjustForm(index) {
            let stockHistoryObject = _.cloneDeep(this.$parent.StockHistoryData);
            stockHistoryObject.data[index].editable = true;
            this.adjustMent.adjusted_at = stockHistoryObject.data[index].date;
            this.adjustMent.id = stockHistoryObject.data[index].id;
            this.adjustMent.qty = stockHistoryObject.data[index].qty;
            this.adjustMent.warehouse_id = stockHistoryObject.data[index].warehouse_id;
            this.adjustMent.notes = stockHistoryObject.data[index].notes;
            this.$parent.StockHistoryData = stockHistoryObject;
        },
        getBadgeOrCurrencySign(history, type = 'badge') {
           if (history.type === 'Stock Transfer') {
               return type === 'badge' ?
                   parseInt(history.qty) < 0 ? 'badge-transfer-dec' : 'badge-transfer-inc'
                   :
                   parseInt(history.qty) < 0 ? history.qty : '+' + history.qty.toString();

            } else if (history.type === 'Stock Adjustments') {
                return type === 'badge' ?
                    parseInt(history.qty) < 0 ? 'badge-decrease' : 'badge-increase'
                    :
                    parseInt(history.qty) < 0 ? history.qty : '+' + history.qty.toString();

            } else if (history.type === 'Product Sales') {
                return type === 'badge' ?
                    'badge-success'
                    : '-' + history.qty.toString();
            } else if (history.type === 'Product Returns') {
                return type === 'badge' ?
                    'badge-dark'
                    : '+' + history.qty.toString();
            } else if (history.type === 'Product Purchases') {
                return type === 'badge' ?
                    'badge-info'
                    : '+' + history.qty.toString();
            } else if (history.type === 'Product Free Count') {
                return type === 'badge' ?
                    'badge-primary'
                    : '-' + history.qty.toString();
            } else if (history.type === 'Product Damages') {
                return type === 'badge' ?
                    'badge-warning'
                    : '-' + history.qty.toString();
            } else {
                return type === 'badge' ?
                    'badge-warning'
                    : parseInt(history.qty)
            }

        }
    }
}
</script>

<style>
.vm--modal {
    top: 20px !important;
}

.badge-increase {
    background: #4a69bd;
    color: #fff;
}
.badge-transfer-dec{
    background: #33d9b2;
    color: #fff;
}
.badge-transfer-inc{
    background: #38ada9;
    color: #fff;
}
.badge-decrease {
    background: #40407a;
    color: #fff;
}
.tbl-height{
    height: 500px;
    overflow: auto;
}
</style>
