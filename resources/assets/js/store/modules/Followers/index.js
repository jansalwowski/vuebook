import {
    GET_FOLLOWING, GET_FOLLOWERS, FOLLOWER_FOLLOW, FOLLOWING_FOLLOW, FOLLOWER_UNFOLLOW, FOLLOWING_UNFOLLOW,
    CLEAR_FOLLOWERS, CLEAR_FOLLOWING
} from "../../types";
const state = {
    following: [],
    followingCount: 0,
    followers: [],
    followersCount: 0,
};

const mutations = {
    [GET_FOLLOWING] (state, {following, followingCount}) {
        state.following = following;
        state.followingCount = followingCount;
    },

    [FOLLOWING_FOLLOW] (state, username) {
        let user = state.following.find((u) => u.username === username);

        if (user) {
            user.isFollowed = true;
        }
    },

    [FOLLOWING_UNFOLLOW] (state, username) {
        let user = state.following.find((u) => u.username === username);

        if (user) {
            user.isFollowed = false;
        }
    },

    [GET_FOLLOWERS] (state, {followers, followersCount}) {
        state.followers = followers;
        state.followersCount = followersCount;
    },

    [FOLLOWER_FOLLOW] (state, username) {
        let user = state.followers.find((u) => u.username === username);

        if (user) {
            user.isFollowed = true;
        }
    },

    [FOLLOWER_UNFOLLOW] (state, username) {
        let user = state.followers.find((u) => u.username === username);

        if (user) {
            user.isFollowed = false;
        }
    },

    [CLEAR_FOLLOWERS] (state) {
        state.followers = [];
        state.followersCount = 0;
    },

    [CLEAR_FOLLOWING] (state) {
        state.following = [];
        state.followingCount = 0;
    }

};

const actions = {
    getFollowing({commit}, username) {
        return new Promise((resolve, reject) => {
            Vue.http.get('users/' + username + '/following')
                .then(response => {
                    let body = response.body;

                    commit(GET_FOLLOWING, {
                            following: body.following,
                            followingCount: body.followingCount
                        }
                    );

                    resolve(body);
                })
                .catch(response => {
                    reject(response.body);
                })
        });
    },

    getFollowers({commit}, username) {
        return new Promise((resolve, reject) => {
            Vue.http.get('users/' + username + '/followers')
                .then(response => {
                    let body = response.body;

                    commit(GET_FOLLOWERS, {
                            followers: body.followers,
                            followersCount: body.followersCount
                        }
                    );

                    resolve(body);
                })
                .catch(response => {
                    reject(response.body);
                })
        });
    },

    clearFollowers({commit}) {
        commit(CLEAR_FOLLOWERS);
    },

    clearFollowing({commit}) {
        commit(CLEAR_FOLLOWING);
    }
};

export default {
    state,
    mutations,
    actions
};