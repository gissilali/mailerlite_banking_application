<template>
  <div>
    <div class="container" v-if="loading">loading...</div>

    <div class="container" v-if="!loading">
      <b-card :header="'Welcome, ' + account.name" class="mt-3">
        <b-card-text>
          <div>
            Account: <code>{{ account.id }}</code>
          </div>
          <div>
            Balance:
            <code
            >{{
                account.currency === "usd" ? "$" : "€"
              }}{{ account.balance }}</code
            >
          </div>
        </b-card-text>
        <b-button size="sm" variant="success" @click="show = !show"
        >New payment
        </b-button
        >

        <b-button
          class="float-right"
          variant="danger"
          size="sm"
          nuxt-link
          to="/"
        >Logout
        </b-button
        >
      </b-card>

      <b-card class="mt-3" header="New Payment" v-show="show">
        <b-form @submit.prevent="onSubmit">
          <b-form-group id="input-group-1" label="To:" label-for="input-1">
            <b-form-input
              id="input-1"
              size="sm"
              v-model="payment.to"
              type="number"
              required
              placeholder="Destination ID"
            ></b-form-input>
          </b-form-group>

          <b-form-group id="input-group-2" label="Amount:" label-for="input-2">
            <b-input-group prepend="$" size="sm">
              <b-form-input
                id="input-2"
                v-model="payment.amount"
                type="number"
                required
                placeholder="Amount"
              ></b-form-input>
            </b-input-group>
          </b-form-group>

          <b-form-group id="input-group-3" label="Details:" label-for="input-3">
            <b-form-input
              id="input-3"
              size="sm"
              v-model="payment.details"
              required
              placeholder="Payment details"
            ></b-form-input>
          </b-form-group>

          <b-button type="submit" size="sm" variant="primary">Submit</b-button>
        </b-form>
      </b-card>

      <b-card class="mt-3" header="Payment History">
        <b-table striped hover :items="transactions"></b-table>
      </b-card>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {

  data() {
    return {
      show: false,
      payment: {},
      formErrors: {},
      account: null,
      transactions: null,

      loading: true
    };
  },

  mounted() {
    this.getTransactions();
    this.getAccount();
  },

  methods: {
    onSubmit(event) {
      event.preventDefault();

      axios.post(`${process.env.APP_URL}/api/accounts/${this.$route.params.id}/transactions`, this.payment)
        .then(({data, status}) => {
          this.payment = {};
          this.show = false;
          //update items
          this.getAccount();
          this.getTransactions();
        })
        .catch(({response}) => {
          if (response.status === 422) {
              this.formErrors = response.data.errors;
          }
        });
    },
    getAccount() {
      axios
        .get(`${process.env.APP_URL}/api/accounts/${this.$route.params.id}`)
        .then(({data, status}) => {
          if (status === 200) {
            this.account = data.data;
            if (data.data) {
              this.account = data.data;
              if (this.account && this.transactions) {
                this.loading = false;
              }
            } else {
              window.location = "/";
            }
          }
        });
    },
    getTransactions() {
      axios
        .get(`${process.env.APP_URL}/api/accounts/${this.$route.params.id}/transactions`)
        .then(({data, status}) => {
          if (status === 200) {
            if (data.data != null) {
              this.transactions = data.data.map((transaction) =>{
                transaction.created_at = this.$dayjs(transaction.created_at).format('DD MMM, YYYY HH:mm')
                transaction.updated_at = this.$dayjs(transaction.updated_at).format('DD MMM, YYYY HH:mm')
                return transaction;
              });
            }
          }
        })
    }
  }
};
</script>
