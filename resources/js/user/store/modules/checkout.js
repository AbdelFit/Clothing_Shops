import axios from "axios"
import router from '../../router/index'
export default {
    state: {
        coupon_value: localStorage.getItem("coupon_value") || "",
        coupon_code: localStorage.getItem("coupon_code") || "",
        loading: false,
        error_coupon: 0,
        errors: 0,
        message: null
    },
    getters: {
        couponCode(state) {
            return state.coupon_code
        },
        couponValue(state) {
            return state.coupon_value
        },
        loading(state) {
            return state.loading
        },
        errorCoupon(state) {
            return state.error_coupon
        },
        errorsCheckout(state) {
            return state.errors
        },
        messageError(state) {
            return state.message
        },
    },
    mutations: {
        loadingState(state) {
            state.loading = true
        },
        initCheckout(state) {
            state.error_coupon = ""
            state.errors = ""
        },
        couponSuccess(state, payload) {
            state.loading = false
            state.error_coupon = ""
            state.coupon_value = payload.data.coupon.value
            state.coupon_code = payload.data.coupon.coupon
            localStorage.setItem("coupon_value", state.coupon_value)
            localStorage.setItem("coupon_code", state.coupon_code)
        },
        couponFaild(state, payload) {
            state.loading = false
            state.error_coupon = payload.response.data.errors
        },
        orderSuccess(state) {
            state.loading = false
            state.errors = ""
            let user = localStorage.getItem('user');
            localStorage.clear();
            localStorage.setItem('user', user);
            router.push('/thankyou')
        },
        orderFailed(state, payload) {
            state.loading = false
            if (payload.response.status === 422) {
                state.errors = payload.response.data.errors
            }
        }
    },
    actions: {
        loadingState({
            commit
        }, name) {
            commit('loadingState', name)
        },
        checkCoupon({
            commit
        }, coupon) {
            axios.get("/api/coupon/check", {
                params: {
                    coupon
                }
            }).then(response => {
                commit("couponSuccess", response)
            }).catch(error => {
                commit("couponFaild", error)
            })
        },
        submitOrder({
            commit,
            rootState
        }, payload) {
            payload.append('session_cart', JSON.stringify(rootState.cart.cart))
            payload.append('coupon_value', rootState.checkout.coupon_value)
            payload.append('coupon_code', rootState.checkout.coupon_code)
            payload.append('total_cost', rootState.cart.totalCost)
            axios
                .post("/api/orders", payload)
                .then(() => {
                    rootState.cart.cart = []
                    commit("orderSuccess");
                })
                .catch(error => {
                    commit("orderFailed", error)
                });
        }

    }
}
