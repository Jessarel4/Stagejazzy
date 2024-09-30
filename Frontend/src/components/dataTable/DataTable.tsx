import { useState, useEffect } from "react";
import { DataGrid, GridColDef } from "@mui/x-data-grid";
import axios from "axios";
import "./dataTable.scss";

const DataTable = () => {
  const [rows, setRows] = useState([]);

  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await axios.get("http://127.0.0.1:8000/api/users");
        console.log("Données de l'API:", response.data); // Vérifiez les données reçues
        const users = response.data.map((user: any) => ({
          id: user.id_user,
          firstName: user.prenom_user,
          lastName: user.nom_user,
        dateAcceptation: user.date_acceptation,
        statusPolitique: user.status_politique,
        idDirection: user.id_direction,
        idGroupe: user.id_groupe,
        }));
        setRows(users);
        console.log("Rows après la mise à jour:", users); // Vérifiez les données dans le tableau
      } catch (error) {
        console.error("Erreur lors du chargement des données:", error);
      }
    };

    fetchData();
  }, []);

  const columns: GridColDef[] = [
    { field: 'id', headerName: 'ID', width: 90 },
    { field: 'firstName', headerName: 'Prénom', width: 150 },
    { field: 'lastName', headerName: 'Nom', width: 150 },
    { field: 'dateAcceptation', headerName: 'Date d\'acceptation', width: 250 },
    { field: 'statusPolitique', headerName: 'Statut politique', width: 150 },
    { field: 'idDirection', headerName: 'Direction', width: 150 },
    { field: 'idGroupe', headerName: 'Groupe', width: 90 },
  ];
  

  return (
    <div className="dataTable">
      <DataGrid
        rows={rows}
        columns={columns}
        initialState={{
          pagination: {
            paginationModel: {
              pageSize: 5,
            },
          },
        }}
        pageSizeOptions={[5]}
        checkboxSelection
        disableRowSelectionOnClick
      />
    </div>
  );
};

export default DataTable;
