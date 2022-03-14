# Api Rest for the Contract App

### Api designed to manage all the data requested by the Contract App application.

## Tecnologia de desarrollo

-   Laravel Lumen

## EndPoints

**CONTRACTS**

-   **GET**

    -   /contracts: Obtaining contracts
    -   /contracts/trash: Obtaining contracts in garbage
    -   /contracts/trash/id(number): Recovering a specific waste contract
    -   /contracts/contract/id: Obtain a specific contract

-   **POST**
    -   /contracts: Add contract
    -   /contracts/contract/id: Update contract
-   **DEL**
    -   /contracts/id: Delete contract

**CONTRACT STATUS**

-   **GET**
    -   /contracts/status: Obtain status
    -   /contracts/status/id: Obtain a status
-   **POST**
    -   /contracts/status: Add status
    -   /contracts/status/id: Maintain a status
-   **DEL**
    -   /contracts/status/id: Drilling status

**CONTRACT TYPE**

-   **GET**
    -   /contracts/types: Get type
    -   /contracts/types/id: Get a type
-   **POST**
    -   /contracts/types: Add type
    -   /contracts/types/id: update type
-   **DEL**
    -   /contracts/types/id: delete type

**WORKERS**

-   **GET**

    -   /workers: Obtaining workers

    *   /workers/indexRelationships: Obtain workers with data relationships

    -   /workers/trash: Obtaining garbage workers
    -   /workers/trash/id(number): Recover a specific waste worker
    -   /workers/worker/id: Obtain a specific worker

-   **POST**
    -   /workers: Add worker
    -   /workers/contract/id: Update worker
-   **DEL**
    -   /workers/id: Delete worker
