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
            toastr.error('Failed to load states.');
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
            toastr.error('Failed to load states or cities.');
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
            toastr.error('Failed to load states.');
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
            toastr.error('Failed to load operation areas.');
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
            toastr.error('Failed to load sub categories.');
        });
}

function getSubChildCategories(parentId, route, subChildId = null) {
    axios.get(route, {
        params: { parent_id: parentId }
    })
        .then(function (response) {
            if (response.data.sub_childrens.length > 0) {
                $('#sub_childrens').html(`<option value="" selected hidden>Select Sub Child Category</option>`);
                response.data.sub_childrens.forEach(function (sub_children) {
                    $('#sub_childrens').append(`<option value="${sub_children.id}" ${sub_children.id == subChildId ? 'selected' : ''}>${sub_children.name}</option>`);
                });
                $('#sub_childrens').prop('disabled', false);
            } else {
                $('#sub_childrens').html(`<option value="" selected hidden>Select Sub Child Category</option>`).prop('disabled', true);
            }
        }
        )
        .catch(function (error) {
            console.error(error);
            $('#sub_childrens').html(`<option value="" selected hidden>Select Sub Child Category</option>`).prop('disabled', true);
            toastr.error('Failed to load sub child categories.');
        });
}

function getTaxRates(TaxClassId, route) {
    axios.post(route, { tax_class_id: TaxClassId })
        .then(function (response) {
            if (response.data.tax_rates.length > 0) {
                $('#tax_rate_id').html(`<option value="" selected hidden>Select Tax Rate</option>`);
                response.data.tax_rates.forEach(function (tax_rate) {
                    $('#tax_rate_id').append(`<option value="${tax_rate.id}">${tax_rate.name}</option>`);
                });
                $('#tax_rate_id').prop('disabled', false);
            } else {
                $('#tax_rate_id').html(`<option value="" selected hidden>Select Tax Rate</option>`).prop('disabled', true);
            }
        })
        .catch(function (error) {
            console.error(error);
            $('#tax_rate_id').html(`<option value="" selected hidden>Select Tax Rate</option>`).prop('disabled', true);
            toastr.error('Failed to load tax rates.');
        });
}


function getBrands(companyId, route, brandId = null) {

    axios.post(route, { company_id: companyId })
        .then(function (response) {
            if (response.data.brands.length > 0) {
                $('#brand_id').html(`<option value="" selected hidden>Select Brand</option>`);
                response.data.brands.forEach(function (brand) {
                    $('#brand_id').append(`<option value="${brand.id}" ${brand.id == brandId ? 'selected' : ''}>${brand.name}</option>`);
                });
                $('#brand_id').prop('disabled', false);
            } else {
                $('#brand_id').html(`<option value="" selected hidden>Select Brand</option>`).prop('disabled', true);
            }
        })
        .catch(function (error) {
            console.error(error);
            $('#brand_id').html(`<option value="" selected hidden>Select Brand</option>`).prop('disabled', true);
            toastr.error('Failed to load brands.', error);
        });
}

function getModels({
    companyId = null,
    brandId = null,
    route,
    modelId = null
}) {
    let axiosCall;
    if (companyId) {
        axiosCall = axios.post(route, { company_id: companyId });
    } else if (brandId) {
        axiosCall = axios.post(route, { brand_id: brandId });
    } else {
        toastr.error('Failed to load models.', 'Please select company or brand.');
        return;
    }
    axiosCall.then(function (response) {
        if (response.data.models.length > 0) {
            $('#brand_id').html(`<option value="" selected hidden>Select Model</option>`);
            response.data.models.forEach(function (model) {
                $('#model_id').append(`<option value="${model.id}" ${model.id == modelId ? 'selected' : ''}>${model.name}</option>`);
            });
            $('#model_id').prop('disabled', false);
        } else {
            $('#model_id').html(`<option value="" selected hidden>Select Model</option>`).prop('disabled', true);
        }
    })
        .catch(function (error) {
            console.error(error);
            $('#model_id').html(`<option value="" selected hidden>Select Model</option>`).prop('disabled', true);
            toastr.error('Failed to load models.', error);
        });
}
