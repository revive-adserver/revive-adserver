function RV_downloadReport(url) {
    let request = new XMLHttpRequest();

    request.addEventListener('loadstart', window.FreezeUI);
    request.addEventListener('loadend', window.UnFreezeUI);
    request.addEventListener('error', window.UnFreezeUI);
    request.addEventListener('abort', window.UnFreezeUI);

    request.open('GET', url, true);
    request.responseType = 'blob';
    request.onload = function (e) {
        var data = request.response;
        var blobUrl = window.URL.createObjectURL(data);
        var downloadLink = document.createElement('a');
        var utf8Name = request.getResponseHeader('content-disposition').match(/filename\*=UTF-8''(.*)$/)
        var asciiName = request.getResponseHeader('content-disposition').match(/filename="(.*)"/)

        downloadLink.href = blobUrl;
        downloadLink.download = utf8Name.length > 1 ? decodeURIComponent(utf8Name[1]) : (asciiName.length > 1 ? asciiName[1] : 'download.zip');
        downloadLink.click();
    };

    request.send();

    return request;
}
