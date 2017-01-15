import {
    CLEAR_PROFILE, GET_USER, FOLLOW_USER, UNFOLLOW_USER, SET_FOLLOWED, SET_IS_OWN_PROFILE, SET_COVER_PHOTO,
    FOLLOWING_FOLLOW, FOLLOWER_FOLLOW, FOLLOWING_UNFOLLOW, FOLLOWER_UNFOLLOW, SET_AVATAR
} from "../../types";
const state = {
    user: {},
    followed: false,
    ownProfile: false
};

const getters = {
    getProfileUser(state) {
        return state.user;
    },

    isOwnProfile(state) {
        return state.ownProfile;
    }
};

const mutations = {
    [GET_USER] (state, user) {
        state.user = user;
    },

    [CLEAR_PROFILE] () {
        state.user = {};
        state.followed = false;
        state.ownProfile = false;
    },

    [FOLLOW_USER] (state) {
        state.followed = true;
    },

    [UNFOLLOW_USER] (state) {
        state.followed = false;
    },

    [SET_FOLLOWED] (state, isFollowed) {
        state.followed = isFollowed;
    },

    [SET_IS_OWN_PROFILE] (state, ownProfile) {
        state.ownProfile = ownProfile;
    },

    [SET_AVATAR] (state, {userId, avatar}) {
        if (state.user.id === userId && state.user.hasOwnProperty('avatar')) {
            state.user.avatar = avatar;
        }
    },

    [SET_COVER_PHOTO] (state, {userId, cover}) {
        if (state.user.id === userId && state.user.hasOwnProperty('cover')) {
            state.user.cover = cover;
        }
    }
};

const actions = {
    getProfile({commit}, username) {
        return new Promise((resolve, reject) => {
            Vue.http.get('profile/' + username)
                .then((response) => {
                    commit(GET_USER, response.body.user);
                    commit(SET_IS_OWN_PROFILE, response.body.ownProfile);
                    commit(SET_FOLLOWED, response.body.followed);

                    resolve(response.body);
                })
                .catch((response) => {
                    reject(response.body);
                });
        });
    },

    follow({commit}, username) {
        return new Promise((resolve, reject) => {
            Vue.http.post('users/' + username + '/follow')
                .then((response) => {
                    commit(FOLLOW_USER);
                    commit(FOLLOWING_FOLLOW, username);
                    commit(FOLLOWER_FOLLOW, username);

                    resolve(response.body);
                })
                .catch((response) => {
                    reject(response.body);
                });
        });
    },

    unfollow({commit}, username) {
        return new Promise((resolve, reject) => {

            Vue.http.delete('users/' + username + '/unfollow')
                .then((response) => {
                    commit(UNFOLLOW_USER);
                    commit(FOLLOWING_UNFOLLOW, username, { root: true });
                    commit(FOLLOWER_UNFOLLOW, username, { root: true });

                    resolve(response.body);
                })
                .catch((response) => {
                console.log(response);
                    reject(response.body);
                });
        });
    },

    clearProfile({commit}) {
        commit(CLEAR_PROFILE);
    }
};

export default {
    state,
    getters,
    mutations,
    actions
};