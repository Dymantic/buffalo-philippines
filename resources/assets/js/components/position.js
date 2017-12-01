function parsePosition(position) {
    return {
        coords: {lat: position.coords.latitude, lng: position.coords.longitude},
        latitude: position.coords.latitude,
        longitude: position.coords.longitude,
        accuracy: position.coords.accuracy,
        is_accurate: position.coords.accuracy < 5000
    }
}


export default {

    getCurrent() {


        return new Promise((resolve, reject) => {
            if(!window.navigator.geolocation) {
                reject('Browser does not support geo-location');
            }
            window.navigator.geolocation.getCurrentPosition(
                (pos) => resolve(parsePosition(pos)),
                () => reject('Failed to get location')
            );
        });
    },

    watchCurrent(cb, fail) {
            if(!window.navigator.geolocation) {
                fail('Browser does not support geo-location');
            }
            window.navigator.geolocation.watchPosition(
                (pos) => cb(parsePosition(pos)),
                () => fail('Failed to get location')
            );
    }
}