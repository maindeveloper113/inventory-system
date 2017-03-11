package com.inventory.cis;


public class ListModel {
	private Integer InventoryId = 0;

	private String Image="";
	private String Location="";
	private String Remark="";
	private String Description = "";
	private String InventoryPartnumber="";
	private String InventorySerialnumber="";
	private String InventoryRegistertime="";
	private String InventoryRegisterUserName="";
	private Integer Quantity;

	public String getInventoryRegisterUserName() {
		return InventoryRegisterUserName;
	}

	public void setInventoryRegisterUserName(String inventoryRegisterUserName) {
		InventoryRegisterUserName = inventoryRegisterUserName;
	}

	public String getInventoryRegistertime() {
		return InventoryRegistertime;
	}

	public void setInventoryRegistertime(String inventoryRegistertime) {
		InventoryRegistertime = inventoryRegistertime;
	}

	public String getInventorySerialnumber() {
		return InventorySerialnumber;
	}

	public void setInventorySerialnumber(String inventorySerialnumber) {
		InventorySerialnumber = inventorySerialnumber;
	}

	public String getInventoryPartnumber() {
		return InventoryPartnumber;
	}

	public void setInventoryPartnumber(String inventoryPartnumber) {
		InventoryPartnumber = inventoryPartnumber;
	}



	/*********** Set Methods ******************/



	public void setImage(String Image)
	{
		this.Image = Image;
	}
	public void setInventoryId(Integer id)
	{
		this.InventoryId = id;
	}

	public void setLocation(String Location)
	{
		this.Location = Location;
	}
	public void setDescription(String Description)
	{
		this.Description = Description;
	}

	/*********** Get Methods ****************/


	public String getImage()
	{
		return this.Image;
	}
	public Integer getInventoryId()
	{
		return this.InventoryId;
	}

	public String getLocation()
	{
		return this.Location;
	}
	public String getDescription()
	{
		return this.Description;
	}

	public String getRemark() {
		return Remark;
	}

	public void setRemark(String remark) {
		Remark = remark;
	}

	public Integer getQuantity() {
		return Quantity;
	}

	public void setQuantity(Integer quantity) {
		Quantity = quantity;
	}
}
