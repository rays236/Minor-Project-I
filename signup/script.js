/*
onerror = errorHandler
document.wrt("Welcome to this website")

function errorHandler(message, url, line){
    out = "Sorry, an error was encountered.\n\n>"
    out+="Error: " + message + "\n\n>"
    out+="URL: " + url + "\n\n"
    out += "Line: " + line + "\n\n"
    out += "Click OK to continue. " + "\n\n"
    alert(out);
    return true;
}
*/

function validate(form){
    fail = validateFirstname(form.firstname.value)
    fail += validateSurname(form.Surname.value)
    fail += validateUsername(form.Username.value)
    fail += validatePassword(form.password.value)

    if (fail == "") return true
    else{
        alert(fail);
        return false
    }
}

function validateFirstname(field){
    return (field == "")?"No Firstname was entered.\n" : ""
}

function validateSurname(field){
    return (field == "")?"No Surname was entered.\n" : ""
}

function validateUsername(field){
    if (field == "") 
        return "No Username was entered.\n"
    else if (field.length < 5)
        return " Username must be atleast 5 characters. \n"
    else if(/[^a-zA-Z0-9]/.test(field))
        return "Only a-z, A-Z, 0-9, - and _ allowed in Usernames.\n"
    return ""
}

function validatePassword(field){
    if (field == "")
        return 'No password was entered.\n'
    else if (field.length < 6)
        return "Password must be at least 6 characters.\n"
    else if (!/[a-z]/.test(field) || !/[A-Z]/.test(field) || !/[0-9]/.test(field))
        return " Passwords require one each of a-z, A-Z and 0-9.\n"
    return ""
}
