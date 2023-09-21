/**
 * @param {object} config - request configuration object
 * @param {function} successCallback - lambda function for success request
 * @param {function} errorCallback - lambda function for failed request
 */
function HttpAgent( config, successCallback, errorCallback) {
    /* debug status check */
    let debug = (('debug' in config) && config.debug);
    
    /* validation */
    let validation = [
        'uri',
        'method',
        'payload',
        'headers',
    ];
    // check main config
    if (!config) {
        console.error('process stopped due to missing configuration.');
        return 0;
    }
    // main validation loop
    validation.forEach(function (item) {
            if (!(item in config)) {
            throw 'Error: process stopped due to missing config parameter, [' + item + '] is required.';
        }
    });
    
    // check if config payload & headers are objects
    (typeof config.payload !== 'object') && ShortThrowError('Error: process stopped due to bad config parameter, Payload should be object');
    (typeof config.headers !== 'object') && ShortThrowError('Error: process stopped due to bad config parameter, Headers should be object');
    
    
    /* note for debug */
    (debug) && console.info("validation passed. uploading payload to " + config.uri + "  ...");
    
    /* Process main request */
    axios[config.method](config.uri, config.payload, config.headers)
      .then(function (response) {
          // handle success
          successCallback();
      })
      .catch(function (error) {
          // handle error
          errorCallback();
      })
      .finally(function () {
          // always executed
          (debug) && console.warn('end of request lifecycle (with or without error).');
      });
}