<template>
    <modal name="stock-hidden" transition="nice-modal-fade" height="auto" :draggable="true" :scrollable="true">
        <div style="padding: 25px;cursor: move">
        <h4 class="text-center">Hidden from stock</h4>
        <table class="table table-sm">
            <tr>
                <td>sl</td>
                <td>Product Name</td>
                <td>Action</td>
            </tr>
            <tr v-for="(item,index) in hiddenItems" :key="index">
                <td>{{ index + 1 }}</td>
                <td>{{ item.product_name }}</td>
                <td>
                    <button @click="Restore(item)" type="button" class="btn btn-success btn-sm"><i
                        class="fas fa-trash-restore"></i> Restore
                    </button>
                </td>
            </tr>
        </table>
        </div>
    </modal>
</template>

<script>
export default {
    name: "StockHidden",
    data() {
        return {
            hiddenItems: [],
            base_url: '',
        }
    },
    methods: {
        showHiidenProducts(){
            axios.get(this.$parent.base_url + '/admin/get_stock_hidden_items')
                .then((res) => {
                    this.hiddenItems = res.data;
                    this.$modal.show('stock-hidden');
                })
        },
        Restore(product) {
            let confirmation = confirm('Are you sure you want to restore product?')
            if (confirmation) {
                this.$Progress.start();
                axios.post(this.$parent.base_url + '/admin/restore_from_stock/' + product.id)
                    .then((res) => {
                        iziToast.success({
                            title: 'Success',
                            position: 'topRight',
                            message: 'Product Restored successfully',
                        });
                        this.$Progress.finish();
                        location.reload()
                    })
                    .catch(err => {
                        iziToast.error({
                            title: 'Error',
                            position: 'topRight',
                            message: err.response.data.message,
                        });
                        this.$Progress.fail();
                    })
            }
        }
    }
}
</script>

<style>

</style>
