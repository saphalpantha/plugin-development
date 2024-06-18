


// import React, { useState } from "react";
// import classes from "./Todo.module.css";
// import { QueryClient, useMutation, useQuery } from "react-query";
// import { useForm } from "react-hook-form"


// import TodoCard from "./TodoCard";



// const Todo = () => {


  
//   const {register, handleSubmit, watch, formState: { errors }, } = useForm()
  
//   const [isSubmitClicked, setIsSubmitClicked] = useState(false);

//   const fetchTodos = async () => {
//     const res = await fetch(
//       "http://localhost/plugin-development/third-day/api/server.php"
//     );
//     return res.json();
//   };


//   const {title} = watch();


//   const submitHandler = (userInput) => {
//     setIsSubmitClicked(true);
//     console.log(userInput);
//   }

  
//   const { isLoading, error, data } = useQuery("todos", fetchTodos);

//   if (error) {
//     return <h1>Failed to Load</h1>
//   }


//   return (
//     <div className={classes.main}>
//       <form onSubmit={handleSubmit(submitHandler)}>
//       {(title.length === 0 && isSubmitClicked) && <span style={{color:'lightpink'}}>Title is Required</span> }
  

//         <input
//           {...register("title")}
//           placeholder="What do you need to do ?"
//         />

//         <button
//         type="submit">
//           Add
//         </button>
//       </form>

//       <div className={classes["todo-list"]}>
//         {data.data.length() === 0 && <span>No Todos</span>}
//         {isLoading ? (
//           <h1>Loading</h1>
//         ) : (
//           data?.data.map((i) => (
//             <TodoCard title={i.title} id={i.id} status={i.status} />
//           ))
//         )}
//       </div>
//     </div>
//   );
// };

// export default Todo;




import React, { useState } from "react";
import classes from "./Todo.module.css";
import { useQuery } from "react-query";
import { useForm } from "react-hook-form";
import TodoCard from "./TodoCard";

const Todo = () => {
  const { register, handleSubmit, watch, formState: { errors } } = useForm();
  const [isSubmitClicked, setIsSubmitClicked] = useState(false);

  const fetchTodos = async () => {
    const res = await fetch("http://localhost/plugin-development/third-day/api/server.php/");
    if (!res.ok) {
      throw new Error("Network response was not ok");
    }
    return res.json();
  };

  const { title } = watch();


  const submitHandler = async (userInput) => {
    setIsSubmitClicked(true);
    if(title.length === 0){
      return;
    }
    
    const res = await fetch('http://localhost/plugin-development/third-day/api/server.php', {
      method:'POST',

      body:JSON.stringify(userInput),
    });




    if(!res.ok){
      throw new Error('Failed to Fetch');
    }
    const data = await res.json();
    alert(`${data?.message}`)

  
    
  };

  const { isLoading, error, data } = useQuery("todos", fetchTodos);

  if (error) {
    return <h1>Failed to Load</h1>;
  }

  return (
    <div className={classes.main}>
      <form onSubmit={handleSubmit(submitHandler)}>
        {(title?.length === 0 && isSubmitClicked) && <span style={{ color: 'lightpink' }}>Title is Required</span>}
        <input {...register("title")} placeholder="What do you need to do?" />
        <button type="submit">Add</button>
      </form>

      <div className={classes["todo-list"]}>
        {isLoading ? (
          <h1>Loading</h1>
        ) : (
          data?.data.length === 0 ? (
            <span>No Todos</span>
          ) : (
            data?.data.map((i) => (
              <TodoCard key={i.id} title={i.title} id={i.id} status={i.status} />
            ))
          )
        )}
      </div>
    </div>
  );
};

export default Todo;










// import React, { useState } from "react";
// import classes from "./Todo.module.css";
// import { useQuery } from "react-query";
// import { useForm } from "react-hook-form";
// import TodoCard from "./TodoCard";

// const Todo = () => {
//   const { register, handleSubmit, watch, formState: { errors } } = useForm();
//   const [isSubmitClicked, setIsSubmitClicked] = useState(false);

//   const fetchTodos = async () => {
//     const res = await fetch("http://localhost/plugin-development/third-day/api/server.php");
//     if (!res.ok) {
//       throw new Error("Network response was not ok");
//     }
//     return res.json();
//   };

//   const { title } = watch();

//   const submitHandler = async (userInput) => {
//     setIsSubmitClicked(true);
    
//     const res = await fetch('http://localhost/plugin-development/third-day/api/server.php', {
//       method: 'POST',
//       headers: {
//         'Content-Type': 'application/json'
//       },
//       body: JSON.stringify(userInput),
//     });

//     if (!res.ok) {
//       alert('Failed to create todo');
//     } else {
//       const data = await res.json();
//       alert(`${data?.message}`);
//     }
//   };

//   const { isLoading, error, data } = useQuery("todos", fetchTodos);

//   if (error) {
//     return <h1>Failed to Load</h1>;
//   }

//   return (
//     <div className={classes.main}>
//       <form onSubmit={handleSubmit(submitHandler)}>
//         {(title?.length === 0 && isSubmitClicked) && <span style={{ color: 'lightpink' }}>Title is Required</span>}
//         <input {...register("title")} placeholder="What do you need to do?" />
//         <button type="submit">Add</button>
//       </form>

//       <div className={classes["todo-list"]}>
//         {isLoading ? (
//           <h1>Loading</h1>
//         ) : (
//           data?.data.length === 0 ? (
//             <span>No Todos</span>
//           ) : (
//             data?.data.map((i) => (
//               <TodoCard key={i.id} title={i.title} id={i.id} status={i.status} />
//             ))
//           )
//         )}
//       </div>
//     </div>
//   );
// };

// export default Todo;




