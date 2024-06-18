import React from "react";
import {Link} from 'react-router-dom'
import classes from "./TodoCard.module.css";

const TodoCard = ({ title, status, id }) => {
  const deleteTodoById = async (id) => {
    const res = await fetch(`http://localhost/plugin-development/third-day/api/server.php?id=${id}`, {
      method:'DELETE',
    })

    if(!res.ok){
      alert('failed to delete');
    }
    else{
      alert(`Succesfully deleted todo with id  ${id} `);
    }
  }
  return (
    <div className={classes["todo-card"]}>
      <div className={classes.status}>
        <div className={status === "pending" ? classes.pending : classes.completed}>
          {status === "pending" ? "pending" : "completed"}
        </div>
      </div>
      <h2>{title}</h2>
      <div style={{display:'flex' , gap:'1rem'}}>
        <Link  to={`edit-todo/${id}`} >Edit</Link>
        <Link onClick={() => deleteTodoById(id)} to={``} >Delete</Link>
      {/* <NavLink to={`edit-todo.php/${id}`} className={({ isActive, isPending }) => isPending ? "pending" : isActive ? "active" : "" }/> */}
      {/* <NavLink to={`remove-todo.php/${id}`} className={({ isActive, isPending }) => isPending ? "pending" : isActive ? "active" : "" }/> */}
      </div>
    </div>
  );
};

export default TodoCard;
