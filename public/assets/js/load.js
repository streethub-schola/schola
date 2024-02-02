//think this through

const students = sessionStorage.getItem('schola-user');
const teacher = sessionStorage.getItem('schola-admin');

if (students) {
    return
} else if(teacher) {
    location.href = '../teachers/index.html'
    
}