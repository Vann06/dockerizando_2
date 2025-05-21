import {defineStore} from 'pinia'

export const useUserStore = defineStore('user', {
    state: () => ({
        user:null
    }), 
    actions: {
        setUser(userData) {
            this.user = userData
        },
        clearUser() {
            this.user = null
        }
    },
    getters: {
        isLoggedIn: (state) => {
            return state.user !== null
        },
        persist:true
        
    }
})