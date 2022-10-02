<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Product Stock
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="left">
                            <form :action="base_url+'/admin/stock/export'" method="POST" style="display: inline">
                                <input name="_token" type="hidden" :value="csrf">
                                <button type="submit" class="btn btn-success btn-sm"><i
                                    class="fas fa-cloud-download-alt"></i> Export
                                </button>
                            </form>
                            <button type="button" @click="Refresh()" class="btn btn-warning mr-3 btn-sm"><i
                                class="fas fa-sync"></i> Refresh
                            </button>

                            <a @click="showHiddenProducts()" href="#" class="btn btn-dark btn-sm"> <i
                                class="fas fa-eye-slash"></i> Hidden <span class="badge badge-danger">{{HiddenProductsCount}}</span></a>
                        </div>
                        <div class="right">
                            <div class="d-flex justify-content-end mb-3">
                                <input @keyup.enter="triggerSearch()" type="text" class="form-control"
                                       placeholder="search" style="width: 260px;height: 35px;border-radius: 0px"
                                       v-model="query">
                                <button @click="triggerSearch()" style="border-radius: 0px" type="button"
                                        class="btn btn-success btn-sm "><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <div v-if="loader" class="text-center p-5 m-5">
                        <div class="lds-ripple">
                            <div></div>
                            <div></div>
                        </div>
                        <h3>Please Wait.......</h3>
                    </div>
                    <table v-if="!loader && ProductCollections.data.length > 0"
                           class="table table-bordered table-striped text-center">
                        <tr>
                            <th>sl</th>
                            <th>Product Name</th>
                            <th>Image</th>
                            <th>Stock</th>
                            <th>Action</th>
                        </tr>
                        <tr v-for="(product,index) in ProductCollections.data" :key="index">
                            <td class="align-middle">{{ProductCollections.from+index}}</td>
                            <td class=" align-middle text-left">{{product.product_name}}
                                <div v-if="product.mfg && product.exp"><small>{{new
                                    Date(product.mfg).toLocaleDateString()}} </small> - <small> {{new
                                    Date(product.exp).toLocaleDateString()}} </small></div>
                            </td>
                            <td class="align-middle"><img
                                style="width: 50px;height: 50px;border-radius: 100%;border: 3px solid #ddd"
                                :src="base_url+'/public/uploads/products/tiny/'+product.image" alt=""></td>
                            <td class="align-middle"><h4>{{getStock(product.id)}}</h4></td>
                            <td class="align-middle"><a href="javascript:void(0)"
                                                        @click="currentProductData = product;showStockHistory(product.id)"
                                                        class="history"
                                                        :class="{ loading: buttonLoader ==  product.id}"><i
                                class="fas fa-history"></i> {{buttonLoader == product.id ? '' : 'History'}} </a>
                                <a @click="openStockAdjustForm(product,getStock(product.id))"
                                   class="btn btn-sm btn-warning" href="javascript:void(0)"> <i class="fas fa-edit"></i>
                                    Adjust</a>
                                <button @click="hideFromStock(product)" type="button" class="btn btn-danger btn-sm"><i
                                    class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                    </table>
                    <div v-else-if="!loader && ProductCollections.data.length <1" class="d-flex justify-content-center">
                        <p style="width: 50%" class="alert alert-danger">Sorry No Data Found</p>
                    </div>


                    <pagination :limit="2" :data="ProductCollections"
                                @pagination-change-page="dataHandling"></pagination>

                </div>
            </div>
        </div>
<!--        <StockAdjust ref="StockAdjust" @regenStock="getData()"/>-->
<!--        <StockHidden ref="StockHidden"/>-->
<!--        <StockHistory ref="StockHistory"/>-->
    </div>
</template>

<script>
import Swal from 'sweetalert2';
import StockHistory from "./StockHistory";
import StockHidden from "./StockHidden";
import StockAdjust from "./StockAdjust";


export default {
    name: "stock-component",
    props: ['products', 'base_url', 'stockinfo', 'todays_date', 'csrf', 'hidden_count'],
    components: {
        StockHistory,
        StockAdjust,
        StockHidden
    },
    created() {
        this.ProductCollections = this.products;
        this.StockInformation = this.stockinfo;
    },
    mounted() {
        this.HiddenProductsCount = this.hidden_count;
    },
    data() {
        return {
            StockHistoryData: [],
            currentProductData: {"product_name": "", "image": ""},
            HiddenProductsCount: 0,
            buttonLoader: "",
            search_string: "",
            loader: false,
            query: '',
            queryField: 'product_name',
            ProductCollections: {},
            StockInformation: {},
            total_data: 0,
            from: 0,
            to: 0,
            searching: false,
        }
    },
    watch: {
        search_string: function (newQ, oldQ) {
            if (newQ === "") {
                this.query = "";
            }
        },
        query: function (newQ, oldQ) {
            if (newQ === "") {
                this.getData();
            } else {
                this.searchData();
            }
        }
    },

    methods: {
        hideFromStock(product) {
            Swal.fire({
                title: 'Hide this from stock?',
                text: "It will be hidden from stock and stock report",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#badc58',
                cancelButtonColor: '#ff7979',
                confirmButtonText: 'Yes, hide it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.HideProcess(product)
                }
            })
        },
        showHiddenProducts() {
            this.$refs.StockHidden.showHiidenProducts();
        },
        HideProcess(product) {
            this.$Progress.start();
            axios.post(this.base_url + '/admin/hide_from_stock/' + product.id)
                .then((res) => {
                    iziToast.success({
                        title: 'Success',
                        position: 'topRight',
                        message: 'Product Hidden successfully',
                    });
                    this.$Progress.finish();
                    this.getData();
                })
                .catch(err => {
                    iziToast.error({
                        title: 'Error',
                        position: 'topRight',
                        message: err.response.data.message,
                    });
                    this.$Progress.fail();
                })
        },
        dataHandling(page) {
            return this.query === '' ? this.getData(page) : this.searchData(page);
        },
        triggerSearch() {
            this.query = this.search_string;
        },
        getData(page = 1) {
            this.$Progress.start();
            axios.get(this.base_url + '/admin/get_product_with_stock/?page=' + page)
                .then(res => {
                    console.log('res', res);
                    this.ProductCollections = res.data.product_collections;
                    this.StockInformation = res.data.stock_info;
                    this.total_data = res.data.product_collections.total;
                    this.from = res.data.product_collections.from;
                    this.to = res.data.product_collections.to;
                    this.HiddenProductsCount = res.data.hidden_count;
                    this.$Progress.finish();
                })
                .catch(err => {
                    console.log(err);
                    this.$Progress.fail();
                })
        },
        Refresh() {
            if (this.search_string == "" && this.query == "") {
                this.getData();
                return;
            } else {
                this.search_string = "";
                this.query = "";
            }

        },
        searchProcess(page) {
            this.searching = true;
            this.loader = true;
            axios.get(this.base_url + '/admin/search_product_with_stock/' + this.queryField + '/' + this.query + '/?page=' + page)
                .then(res => {
                    console.log(res);
                    this.StockInformation = res.data.stock_info;
                    this.ProductCollections = res.data.product_collections;
                    this.total_data = res.data.product_collections.total;
                    this.from = res.data.product_collections.from;
                    this.to = res.data.product_collections.to;
                    this.HiddenProductsCount = res.data.hidden_count;
                })
                .catch(err => {
                    console.log(err);
                })
                .finally(() => {
                    this.searching = false
                    this.loader = false;
                })
        },
        searchData(page = 1) {
            if (this.searching == true) {
                setTimeout(function () {
                    this.searchProcess(page);
                }, 1200);
            }else{
                this.searchProcess(page);
            }
        },

        openStockAdjustForm(product_data, stock_data) {
            this.$refs.StockAdjust.ProductData = product_data;
            this.$refs.StockAdjust.stock = stock_data;
            this.$refs.StockAdjust.form.adjusted_at = this.todays_date;
            this.$refs.StockAdjust.form.qty = "";
            this.$refs.StockAdjust.form.product_id = product_data.id;
            this.$refs.StockAdjust.updateQtyPreview = "";
            this.$modal.show('stock-adjust');
        },

        showStockHistory() {
            this.buttonLoader = this.currentProductData.id;
            axios.get(this.base_url + '/admin/get_stock_history/' + this.currentProductData.id)
                .then(({data}) => {
                    let stockHistryData = data.map((ele) => {
                        return {...ele, editable: false};
                    })
                    this.StockHistoryData = stockHistryData;
                    this.$modal.show('stock-history');
                })
                .catch(e => {
                    console.log(e);
                    this.$Progress.fail();
                })
                .finally(() => {
                    this.buttonLoader = '';
                })

        },

        getStock(product_id) {
            console.log('this.StockInformation', this.StockInformation);
            let result = this.StockInformation.filter((product) => {
                return product_id == product.product_id;
            });
            console.log(result);
            return result[0].stock;
        }
    }
}
</script>

<style scoped>
.__cov-progress {
    z-index: 99999999;
}

/* Loader Css */
.lds-ripple {
    display: inline-block;
    position: relative;
    width: 80px;
    height: 80px;
}

.lds-ripple div {
    position: absolute;
    border: 4px solid #ED4C67;
    opacity: 1;
    border-radius: 50%;
    animation: lds-ripple 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
}

.lds-ripple div:nth-child(2) {
    animation-delay: -0.5s;
}

@keyframes lds-ripple {
    0% {
        top: 36px;
        left: 36px;
        width: 0;
        height: 0;
        opacity: 1;
    }
    100% {
        top: 0px;
        left: 0px;
        width: 72px;
        height: 72px;
        opacity: 0;
    }
}


.history.loading {
    background: #ff7979;
    padding-right: 40px;
}

.history {
    text-decoration: none;
    display: inline-block;
    border: 0;
    outline: 0;
    padding: 2px 5px;
    background: linear-gradient(#44bc9c, #079992);
    border-radius: 5px;
    font-family: "Lucida Grande", "Lucida Sans Unicode", Tahoma, Sans-Serif;
    color: white !important;
    font-size: 1.2em;
    cursor: pointer;
    /* Important part */
    position: relative;
    transition: padding-right .3s ease-out;
}

.history.loading:after {
    content: "";
    position: absolute;
    border-radius: 100%;
    right: 6px;
    top: 50%;
    width: 0px;
    height: 0px;
    margin-top: -2px;
    border: 4px solid rgba(255, 255, 255, 0.5);
    border-left-color: #FFF;
    border-top-color: #FFF;
    animation: spin .6s infinite linear, grow .3s forwards ease-out;
}

@keyframes spin {
    to {
        transform: rotate(359deg);
    }
}

@keyframes grow {
    to {
        width: 16px;
        height: 16px;
        margin-top: -8px;
        right: 13px;
    }
}

</style>
