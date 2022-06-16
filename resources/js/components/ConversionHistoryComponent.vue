<template>
  <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12" v-if="result && Object.keys(result).length !== 0">
                <h3 class="text-center">Histórico de Conversões</h3>
                <div class="card mt-4">
                    <div class="card card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Valor de compra</th>
                                    <th>Forma de Pagamento</th>
                                    <th>Taxa de Pagamento</th>
                                    <th>Taxa de Conversão</th>
                                    <th>Moeda</th>
                                    <th>Valor da Conversão</th>
                                    <th>Data da Consulta</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in result" :key="item.id">
                                    <td>{{ item.id }}</td>
                                    <td>{{ item.value_to_be_converted | formatCurrency }}</td>
                                    <td>{{ item.payment_method == 'bank_slip' ? 'Boleto' : 'Cartão de Crédito' }}</td>
                                    <td>{{ item.payment_tax | formatCurrency }}</td>
                                    <td>{{ item.conversion_tax | formatCurrency }}</td>
                                    <td>{{ item.target_currency }}</td>
                                    <td>{{ item.target_currency == 'USD' ? '$' : '€' }} {{ item.target_currency_purchased_value | formatCurrencyToGeneric }}</td>
                                    <td>{{ item.created_at | formatDate }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div v-else>
                <div class="card mt-6">
                    <div class="card-body">
                        <h4 class="text-center">Ainda não há histórico de conversões.</h4>
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
            result: {},
        }
    },
    filters: {
        formatCurrency: function (value) {
            if (!value) return ''
            const formatter = new Intl.NumberFormat('pt-BR', {
                style: 'currency',
                currency: 'BRL'
            })
            return formatter.format(value)
        },
        formatCurrencyToGeneric: function (value) {
            if (!value) return ''
            return value.toString().replace(".", ",")
        },
        formatDate: function (value) {
            const date = new Date(value);
            return `${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear()}`;
        }
    },
    created: function () {
        this.getResult()
    },
    methods: {
        getResult() {
            axios.get('/history').then(response => {
                this.result = response.data
                console.log(response);
            }).catch(error => {
                console.log(error);
            });
        },
    }
}
</script>

<style>

</style>
