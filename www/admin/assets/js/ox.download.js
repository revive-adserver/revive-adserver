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
        downloadLink.href = blobUrl;
        downloadLink.download = request.getResponseHeader('content-disposition').match(/filename="(.*)"/)[1] || 'download.zip';
        downloadLink.click();
    };

    request.send();

    return request;
}
