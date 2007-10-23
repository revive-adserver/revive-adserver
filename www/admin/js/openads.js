function showLoader(f) {
    var dbLoader = new getObj('dbLoader');
    window.location = '#mid';
    if (dbLoader.style) {
        dbLoader.style.display='block';
        dbLoader.style.height='700px';
    }
}
