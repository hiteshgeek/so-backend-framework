/**
 * Sample Data for DataTable Plugin Demo
 * 100 rows with 20 columns
 */

// Helper function to generate random data
function generateSampleData() {
    const firstNames = ["John", "Jane", "Bob", "Alice", "Charlie", "Diana", "Ethan", "Fiona", "George", "Hannah", "Ian", "Julia", "Kevin", "Laura", "Mike", "Nancy", "Oscar", "Patricia", "Quincy", "Rachel", "Sam", "Tina", "Uma", "Victor", "Wendy"];
    const lastNames = ["Smith", "Johnson", "Williams", "Brown", "Jones", "Garcia", "Miller", "Davis", "Rodriguez", "Martinez", "Hernandez", "Lopez", "Gonzalez", "Wilson", "Anderson", "Thomas", "Taylor", "Moore", "Jackson", "Martin", "Lee", "Perez", "Thompson", "White", "Harris"];
    const departments = ["Sales", "Marketing", "IT", "HR", "Finance", "Operations", "Engineering", "Customer Service", "Research", "Legal"];
    const positions = ["Manager", "Director", "Executive", "Specialist", "Analyst", "Developer", "Lead", "Supervisor", "Coordinator", "Associate"];
    const cities = ["New York", "Los Angeles", "Chicago", "Houston", "Phoenix", "Philadelphia", "San Antonio", "San Diego", "Dallas", "San Jose"];
    const countries = ["USA", "Canada", "UK", "Germany", "France", "Australia", "Japan", "India", "Brazil", "Mexico"];
    const skills = ["Leadership", "Communication", "Analysis", "Programming", "Design", "Management", "Sales", "Marketing", "Finance", "Strategy"];
    const projects = ["Project Alpha", "Project Beta", "Project Gamma", "Project Delta", "Project Epsilon", "Project Zeta", "Project Eta", "Project Theta", "Project Iota", "Project Kappa"];
    const statuses = ["Active", "On Leave", "Remote", "In Office"];
    const educations = ["Bachelor's", "Master's", "PhD", "MBA", "Associate"];

    const data = [];

    for (let i = 1; i <= 100; i++) {
        const firstName = firstNames[Math.floor(Math.random() * firstNames.length)];
        const lastName = lastNames[Math.floor(Math.random() * lastNames.length)];
        const name = firstName + " " + lastName;
        const email = firstName.toLowerCase() + "." + lastName.toLowerCase() + i + "@example.com";
        const department = departments[Math.floor(Math.random() * departments.length)];
        const position = positions[Math.floor(Math.random() * positions.length)];
        const salary = Math.floor(Math.random() * 100000) + 40000;
        const bonus = Math.floor(Math.random() * 20000) + 5000;
        const experience = Math.floor(Math.random() * 20) + 1;
        const age = Math.floor(Math.random() * 30) + 25;
        const city = cities[Math.floor(Math.random() * cities.length)];
        const country = countries[Math.floor(Math.random() * countries.length)];
        const skill = skills[Math.floor(Math.random() * skills.length)];
        const project = projects[Math.floor(Math.random() * projects.length)];
        const status = statuses[Math.floor(Math.random() * statuses.length)];
        const education = educations[Math.floor(Math.random() * educations.length)];

        // Generate random date in last 5 years
        const startDate = new Date();
        startDate.setFullYear(startDate.getFullYear() - Math.floor(Math.random() * 5));
        const joinDate = startDate.toISOString().split('T')[0];

        // Performance rating
        const performance = (Math.random() * 2 + 3).toFixed(1); // 3.0 to 5.0

        // Hours per week
        const hoursPerWeek = Math.floor(Math.random() * 20) + 30; // 30-50 hours

        // Team size
        const teamSize = Math.floor(Math.random() * 20) + 1;

        data.push({
            id: i,
            name: name,
            email: email,
            department: department,
            position: position,
            salary: salary,
            bonus: bonus,
            experience: experience,
            age: age,
            city: city,
            country: country,
            skill: skill,
            project: project,
            joinDate: joinDate,
            status: status,
            education: education,
            performance: parseFloat(performance),
            hoursPerWeek: hoursPerWeek,
            teamSize: teamSize,
            employeeCode: "EMP" + String(i).padStart(4, '0')
        });
    }

    return data;
}

const sampleTableData = generateSampleData();

const sampleColumns = [
    { title: "ID", field: "id", width: 70, bottomCalc: null },
    { title: "Employee Code", field: "employeeCode", width: 120 },
    { title: "Name", field: "name", width: 180, color: "blue" },
    { title: "Email", field: "email", width: 150, wrap: true },
    { title: "Department", field: "department", width: 140, color: "purple" },
    { title: "Position", field: "position", width: 140 },
    { title: "Age", field: "age", width: 80 },
    { title: "Education", field: "education", width: 120 },
    { title: "Experience (Years)", field: "experience", width: 150 },
    { title: "Salary", field: "salary", formatter: "money", formatterParams: { symbol: "$", precision: 0 }, width: 120, color: "green" },
    { title: "Bonus", field: "bonus", formatter: "money", formatterParams: { symbol: "$", precision: 0 }, width: 120, color: "green" },
    { title: "City", field: "city", width: 130 },
    { title: "Country", field: "country", width: 120 },
    { title: "Primary Skill", field: "skill", width: 140 },
    { title: "Current Project", field: "project", width: 150, color: "orange" },
    { title: "Join Date", field: "joinDate", width: 120 },
    { title: "Status", field: "status", width: 120 },
    { title: "Performance Rating", field: "performance", width: 160, color: "amber" },
    { title: "Hours/Week", field: "hoursPerWeek", width: 120 },
    { title: "Team Size", field: "teamSize", width: 110 }
];

/*
 * Column Color Options:
 * Add 'color' property to any column definition to apply a background color.
 *
 * Available colors (aesthetic, Material Design inspired):
 * - 'blue'    - Light blue (#e3f2fd) - Great for primary/identity columns
 * - 'green'   - Light green (#e8f5e9) - Perfect for financial/positive data
 * - 'red'     - Light red (#ffebee) - Use for alerts, warnings, negative values
 * - 'orange'  - Light orange (#fff3e0) - Good for highlighting important data
 * - 'purple'  - Light purple (#f3e5f5) - Nice for categories/departments
 * - 'teal'    - Light teal (#e0f2f1) - Works well for technical/system data
 * - 'pink'    - Light pink (#fce4ec) - Soft highlight for personal info
 * - 'indigo'  - Light indigo (#e8eaf6) - Professional look for IDs/codes
 * - 'cyan'    - Light cyan (#e0f7fa) - Fresh look for dates/times
 * - 'amber'   - Light amber (#fff8e1) - Warm highlight for ratings/scores
 * - 'lime'    - Light lime (#f0f4c3) - Energetic, for metrics/KPIs
 * - 'brown'   - Light brown (#efebe9) - Earthy, for historical data
 * - 'gray'    - Light gray (#f5f5f5) - Neutral, for secondary columns
 *
 * Example usage:
 * { title: "Salary", field: "salary", color: "green" }
 * { title: "Department", field: "department", color: "purple" }
 * { title: "Warning", field: "alerts", color: "red" }
 */
