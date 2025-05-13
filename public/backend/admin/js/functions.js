function generateSlug(str) {
    return str
        .toLowerCase()
        .replace(/\s+/g, "-")
        .replace(/[^\w\u0980-\u09FF-]+/g, "") // Allow Bangla characters (\u0980-\u09FF)
        .replace(/--+/g, "-")
        .replace(/^-+|-+$/g, "");
}
function getStates(countryId, route, stateId = null) {
    axios.get(route, {
        params: { country_id: countryId }
    })
        .then(function (response) {
            if (response.data.states.length > 0) {
                $('#state').html(`<option value="" selected hidden>Select State</option>`);
                response.data.states.forEach(function (state) {
                    $('#state').append(`<option value="${state.id}" ${state.id == stateId ? 'selected' : ''}>${state.name}</option>`);
                });
                $('#state').prop('disabled', false);
            } else {
                $('#state').html(`<option value="" selected hidden>Select State</option>`).prop('disabled', true);
            }
        })
        .catch(function (error) {
            console.error(error);
            $('#state').html(`<option value="" selected hidden>Select State</option>`).prop('disabled', true);
            alert('Failed to load states.');
        });
}
function getStatesOrCity(countryId, route, stateOrCityId = null) {
    axios.get(route, {
        params: { country_id: countryId }
    })
        .then(function (response) {
            if (response.data.states) {
                if (response.data.states.length > 0) {
                    $('#state').html(`<option value="" selected hidden>Select State</option>`);
                    response.data.states.forEach(function (state) {
                        $('#state').append(`<option value="${state.id}" ${state.id == stateOrCityId ? 'selected' : ''}>${state.name}</option>`);

                        $('#city').html(`<option value="" selected hidden>Select City</option>`).prop('disabled', true);
                        $('#operation_area').html(`<option value="" selected hidden>Select Operation Area</option>`).prop('disabled', true);
                    });
                    $('#state').prop('disabled', false);
                } else {
                    $('#state').html(`<option value="" selected hidden>Select State</option>`).prop('disabled', true);
                }
            } else if (response.data.cities) {
                if (response.data.cities.length > 0) {
                    $('#city').html(`<option value="" selected hidden>Select City</option>`);
                    response.data.cities.forEach(function (city) {
                        $('#city').append(`<option value="${city.id}" ${city.id == stateOrCityId ? 'selected' : ''}>${city.name}</option>`);

                        $('#state').html(`<option value="" selected hidden>Select State</option>`).prop('disabled', true);
                        $('#operation_area').html(`<option value="" selected hidden>Select Operation Area</option>`).prop('disabled', true);
                    });
                    $('#city').prop('disabled', false);
                } else {
                    $('#city').html(`<option value="" selected hidden>Select City</option>`).prop('disabled', true);
                }
            } else {
                $('#state').html(`<option value="" selected hidden>Select State</option>`).prop('disabled', true);
                $('#city').html(`<option value="" selected hidden>Select City</option>`).prop('disabled', true);
            }


        })
        .catch(function (error) {
            console.error(error);
            $('#state').html(`<option value="" selected hidden>Select State</option>`).prop('disabled', true);
            $('#city').html(`<option value="" selected hidden>Select City</option>`).prop('disabled', true);
            alert('Failed to load states or cities.');
        });
}

function getCities(stateId, route, cityId = null) {

    axios.get(route, {
        params: { state_id: stateId }
    })
        .then(function (response) {
            if (response.data.cities.length > 0) {
                $('#city').html(`<option value="" selected hidden>Select City</option>`);
                response.data.cities.forEach(function (city) {
                    $('#city').append(`<option value="${city.id}" ${city.id == cityId ? 'selected' : ''}>${city.name}</option>`);
                    $('#operation_area').html(`<option value="" selected hidden>Select Operation Area</option>`).prop('disabled', true);
                });
                $('#city').prop('disabled', false);
            } else {
                $('#city').html(`<option value="" selected hidden>Select City</option>`).prop('disabled', true);
            }
        })
        .catch(function (error) {
            console.error(error);
            $('#city').html(`<option value="" selected hidden>Select City</option>`).prop('disabled', true);
            alert('Failed to load states.');
        });
}
function getOperationAreas(cityId, route, operationAreaId = null) {

    axios.get(route, {
        params: { city_id: cityId }
    })
        .then(function (response) {
            if (response.data.operation_areas.length > 0) {
                $('#operation_area').html(`<option value="" selected hidden>Select Operation Area</option>`);
                response.data.operation_areas.forEach(function (operation_area) {
                    $('#operation_area').append(`<option value="${operation_area.id}" ${operation_area.id == operationAreaId ? 'selected' : ''}>${operation_area.name}</option>`);
                });
                $('#operation_area').prop('disabled', false);
            } else {
                $('#operation_area').html(`<option value="" selected hidden>Select Operation Area</option>`).prop('disabled', true);
            }
        })
        .catch(function (error) {
            console.error(error);
            $('#operation_area').html(`<option value="" selected hidden>Select Operation Area</option>`).prop('disabled', true);
            alert('Failed to load operation areas.');
        });
}


// Username validation
function validateUsername(usernameInput, errorField, errorMsg = 'Username may only contain letters, numbers, and hyphens.', regex = /^[a-zA-Z0-9\-]+$/) {
    // Attach event listeners for input, change, and blur events
    usernameInput.on('input change blur', function () {
        const val = $(this).val().trim();

        // Check if the value matches the regex
        if (val && !regex.test(val)) {
            $(this).addClass('is-invalid');
            errorField.text(errorMsg).show();
        } else {
            $(this).removeClass('is-invalid');
            errorField.hide();
        }
    });
}

function getSubCategories(parentId, route, childId = null) {

    axios.get(route, {
        params: { parent_id: parentId }
    })
        .then(function (response) {
            if (response.data.childrens.length > 0) {
                $('#childrens').html(`<option value="" selected hidden>Select Sub Category</option>`);
                response.data.childrens.forEach(function (children) {
                    $('#childrens').append(`<option value="${children.id}" ${children.id == childId ? 'selected' : ''}>${children.name}</option>`);
                });
                $('#childrens').prop('disabled', false);
            } else {
                $('#childrens').html(`<option value="" selected hidden>Select Sub Category</option>`).prop('disabled', true);
            }
        })
        .catch(function (error) {
            console.error(error);
            $('#childrens').html(`<option value="" selected hidden>Select Sub Category</option>`).prop('disabled', true);
            alert('Failed to load sub categories.');
        });
}
