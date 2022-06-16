<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="alert alert-success" role="alert" v-if="success === true">
                    <strong>E-mail enviado com sucesso!</strong> Confira o seu e-mail.
                </div>

                <div class="card mt-4">
                    <div class="card">
                        <div class="card-body">

                            <form @submit.prevent="submit">
                                <label for="value_to_conversion">Digite um valor entre 1001 e 99999 reais.</label>
                                <input type="number" name="value_to_conversion" id="value_to_conversion" class="form-control mb-2" min="1001" max="99999" v-model="form.value_to_conversion">
                                <div v-if="errors && errors.value_to_conversion" class="text-danger mb-3 mt-0">{{ errors.value_to_conversion[0] }}</div>

                                <label for="currency">Selecione a moeda de destino.</label>
                                <select class="form-control mb-2" name="currency" id="currency" v-model="form.currency">
                                    <option value="" disabled selected="true">Selecione...</option>
                                    <option value="USD">Dólar</option>
                                    <option value="EUR">Euro</option>
                                </select>
                                <div v-if="errors && errors.currency" class="text-danger mb-3 mt-0">{{ errors.currency[0] }}</div>

                                <label for="payment">Selecione a forma de pagamento.</label>
                                <select class="form-control mb-2" name="payment" id="payment" v-model="form.payment">
                                    <option value="" disabled selected="true">Selecione...</option>
                                    <option value="bank_slip">Boleto</option>
                                    <option value="credit_card">Cartão de Crédito</option>
                                </select>
                                <div v-if="errors && errors.payment" class="text-danger mb-3 mt-0">{{ errors.payment[0] }}</div>

                                <button type="submit" class="btn btn-dark mt-3">Converter</button>

                            </form>

                        </div>
                    </div>

                    <div class="mt-3" v-if="result && Object.keys(result).length !== 0">
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th class="text-center">Valor de compra</th>
                                    <th class="text-center">Forma de Pagamento</th>
                                    <th class="text-center">Taxa de Pagamento</th>
                                    <th class="text-center">Taxa de Conversão</th>
                                    <th class="text-center">Moeda</th>
                                    <th class="text-center">Valor da Conversão</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">{{ result.value_to_be_converted | formatCurrency }}</td>
                                    <td class="text-center">{{ result.payment_method == 'bank_slip' ? 'Boleto' : 'Cartão de Crédito' }}</td>
                                    <td class="text-center">{{ result.payment_tax | formatCurrency }}</td>
                                    <td class="text-center">{{ result.conversion_tax | formatCurrency }}</td>
                                    <td class="text-center">{{ result.target_currency }}</td>
                                    <td class="text-center">{{ result.target_currency == 'USD' ? '$' : '€' }} {{ result.target_currency_purchased_value | formatCurrencyToGeneric }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <button @click.prevent="email" class="btn btn-dark mt-3" v-if="loading === false && result && Object.keys(result).length !== 0">
                        Enviar a cotação para o seu e-mail
                    </button>
                    <button class="btn btn-dark mt-3" type="button" disabled  v-if="loading === true">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span class="sr-only">Enviando...</span>
                    </button>

                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                form: {
                    payment: '',
                    currency: '',
                    value_to_conversion: '',
                },
                errors: {},
                result: {},
                mail: {},
                success: false,
                loading: false,
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
            }
        },
        computed: {
            alertVisible () {
                return (this.alertTitle !== '' && this.alertMessage !== '' && this.alertClass !== '')
            }
        },
        created: function () {
            this.getResult()
        },
        methods: {
            submit() {
                axios.post('/submit', this.form).then(response => {
                    this.getResult()
                    this.form = {
                        payment: '',
                        currency: '',
                        value_to_conversion: '',
                    };
                    this.errors = {};
                }).catch(error => {
                        if (error.response.status === 422) {
                        this.errors = error.response.data.errors || {};
                        console.log(error)
                    }
                });
            },
            getResult() {
                axios.get('/result').then(response => {
                    this.result = response.data
                }).catch(error => {
                    console.log(error);
                });
            },
            async email() {
                this.loading = true
                await axios.get('/mail').then(response => {
                    this.mail = response.data
                    this.loading = false
                    this.success = true
                    var self = this
                    window.setTimeout(function() {
                        self.success = false;
                    }, 5000);
                }).catch(error => {
                    console.log(error);
                });
            },
        }
    }
</script>
