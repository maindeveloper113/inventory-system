//
//  InventoryViewController.swift
//  inventory
//
//  Created by admin on 1/25/17.
//  Copyright © 2017 admin. All rights reserved.
//

import UIKit
//import SDWebImage

class InventoryViewController: UIViewController, UITableViewDelegate, UITableViewDataSource{
    
    @IBOutlet var txtSearchKey: UITextField!
    //@IBOutlet var activityindicatorcontainer: UIView!
    
    
    @IBOutlet var activityindicatorcontainer: UIView!
    
    @IBOutlet var tableview: UITableView!
    @IBOutlet var lblEmptyData: UILabel!
    
    var searchKey: String?
    
    var locationArray = [String]()
    var partNumberArray = [String]()
    var serialNumberArray = [String]()
    var quantityArray = [String]()
    var descriptionArray = [String]()
    var remarkArray = [String]()
    var inventoryIdArray = [String]()
    var inventoryImageUrlArray = [String]()
    var registerNameArray = [String]()
    var registerTimeArray = [String]()
    
    var refresher: UIRefreshControl!
    
    override func viewDidLoad() {
        super.viewDidLoad()
        setInit()
        
        
        // Do any additional setup after loading the view.
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
        
    }
    

    
    // In a storyboard-based application, you will often want to do a little preparation before navigation
    override func prepare(for segue: UIStoryboardSegue, sender: Any?) {
        // Get the new view controller using segue.destinationViewController.
        // Pass the selected object to the new view controller.
        if let destinationVC = segue.destination as? InventoryDetailViewController {
            let i = (self.tableview.indexPathForSelectedRow?.row)!
            
            destinationVC.partNumber = partNumberArray[i]
            destinationVC.serialNumber = serialNumberArray[i]
            destinationVC.location = locationArray[i]
            destinationVC.quantity = quantityArray[i]
            destinationVC.descript = descriptionArray[i]
            destinationVC.registerName = registerNameArray[i]
            destinationVC.registerTime = registerTimeArray[i]
            destinationVC.remark = remarkArray[i]
            destinationVC.inventoryId = inventoryIdArray[i]
            destinationVC.inventoryImageURL = inventoryImageUrlArray[i]
            destinationVC.inventoryViewController = self
            
            
        }
    }
    

    @IBAction func goSearch(_ sender: Any) {
        searchKey = txtSearchKey.text
        txtSearchKey.resignFirstResponder()
        refresh()
        
    }
    
    
    @IBAction func goHome(_ sender: Any) {
        self.navigationController?.popViewController(animated: true)
    }
    
    func refresh(){
        locationArray = [String]()
        partNumberArray = [String]()
        serialNumberArray = [String]()
        quantityArray = [String]()
        descriptionArray = [String]()
        remarkArray = [String]()
        inventoryIdArray = [String]()
        inventoryImageUrlArray = [String]()
        self.tableview.reloadData()
        //self.refresher.endRefreshing()
        getData()

        
    }
    func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        return locationArray.count
    }
    
    func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        let cell = self.tableview.dequeueReusableCell(withIdentifier: "cell", for: indexPath) as! CustomeCell
        cell.location.text = locationArray[indexPath.row]
        cell.location.textColor = UIColor.black
        if partNumberArray[indexPath.row] != "" {
            cell.partNumber.text = partNumberArray[indexPath.row]
            cell.partNumber.textColor = UIColor.black
        }
        if serialNumberArray[indexPath.row] != "" {
            cell.serialNumber.text = serialNumberArray[indexPath.row]
            cell.serialNumber.textColor = UIColor.black
        }
        cell.quantity.text = quantityArray[indexPath.row]
        cell.quantity.textColor = UIColor.black
        cell.descript.text = descriptionArray[indexPath.row]
        cell.descript.textColor = UIColor.black
        if remarkArray[indexPath.row] != "" {
            cell.remark.text = remarkArray[indexPath.row]
            cell.remark.textColor = UIColor.black
        }
        
        //cell.photo.image = UIImage.init(named: "placeholder.png")
        cell.photo.sd_setImage(with: NSURL.init(string: inventoryImageUrlArray[indexPath.row]) as! URL, placeholderImage: UIImage.init(named: "placeholder.png"))
        return cell
    }
    
    func setInit() {
        lblEmptyData.isHidden = true
        searchKey = ""
        getData()
    }
    
    func showActivityIndicatory(uiView: UIView) {
        
        let loadingView: UIView = UIView()
        loadingView.frame = CGRect.init(x: 0, y: 0, width: 80, height: 80)
        let screenSize = UIScreen.main.bounds
        let screenWidth = screenSize.width
        let screenHeight = screenSize.height
        loadingView.center = CGPoint.init(x: screenWidth / 2, y: screenHeight / 2)
        loadingView.backgroundColor = UIColor.lightGray.withAlphaComponent(0.7)
        loadingView.clipsToBounds = true
        loadingView.layer.cornerRadius = 10
        
        let actInd: UIActivityIndicatorView = UIActivityIndicatorView()
        actInd.frame = CGRect.init(x:0.0, y:0.0, width:40.0, height:40.0);
        actInd.activityIndicatorViewStyle =
            UIActivityIndicatorViewStyle.whiteLarge
        
        actInd.center = CGPoint.init(x: loadingView.frame.size.width / 2,
                                     y:loadingView.frame.size.height / 2);
        loadingView.addSubview(actInd)
        uiView.addSubview(loadingView)
        
        actInd.startAnimating()
    }

    
    func getData() {
        
        self.activityindicatorcontainer.isHidden = false
        self.showActivityIndicatory(uiView: activityindicatorcontainer)
        
        let json = ["searchkey":searchKey]
        
        do {
            let jsonData = try JSONSerialization.data(withJSONObject: json, options: .prettyPrinted)
            
            let url = StaticData.getlink() + "list_inventory.php"
            
            var request = URLRequest(url: URL(string: url)!)
            
            request.httpMethod = "POST"
            request.httpBody = jsonData
            request.setValue("application/json; charset=utf-8", forHTTPHeaderField: "Content-Type")
            
            
            let task = URLSession.shared.dataTask(with: request) { (data: Data?, response: URLResponse?, error: Error?) in
                
                if error != nil
                {
                    print("error=\(error)")
                    return
                }
                
                // You can print out response object
                print("response = \(response)")
                
                //Let's convert response sent from a server side script to a NSDictionary object:
                do {
                    
                    let json = try JSONSerialization.jsonObject(with: data!, options: .mutableContainers) as? NSArray
                    
                    for item in json! {
                        if let itemDict = item as? NSDictionary {
                            if let location = itemDict.value(forKey: "location") {
                                self.locationArray.append(location as! String)
                            }
                            if let partNumber = itemDict.value(forKey: "part_number") {
                                self.partNumberArray.append(partNumber as! String)
                            }
                            if let serialNumber = itemDict.value(forKey: "serial_number") {
                                self.serialNumberArray.append(serialNumber as! String)
                            }
                            if let quantity = itemDict.value(forKey: "quantity") {
                                self.quantityArray.append(quantity as! String)
                            }
                            if let descript = itemDict.value(forKey: "description") {
                                self.descriptionArray.append(descript as! String)
                            }
                            if let remark = itemDict.value(forKey: "remark") {
                                self.remarkArray.append(remark as! String)
                            }
                            if let registerTime = itemDict.value(forKey: "register_time") {
                                self.registerTimeArray.append(registerTime as! String)
                            }
                            if let registerName = itemDict.value(forKey: "register_username") {
                                self.registerNameArray.append(registerName as! String)
                            }
                            
                            if let id = itemDict.value(forKey: "id") {
                                var img_url:String!
                                if ((id as! String) != "") {
                                    let img_id = id as! String
                                    img_url = StaticData.getlink().replacingOccurrences(of: "Services", with: "img/inventory") + img_id + ".jpg";
                                   
                                }
                                else {
                                    img_url = ""
                                }
                                self.inventoryIdArray.append(id as! String)
                                self.inventoryImageUrlArray.append(img_url)
                            }
                            
                            
                            OperationQueue.main.addOperation {
                                self.lblEmptyData.isHidden = true
                                self.tableview.reloadData()
                            }
                            
                        }
                    }
                    
                    
                } catch {
                    print("error1")
                    DispatchQueue.main.async {
                        self.lblEmptyData.isHidden = false
                    }
                }
                DispatchQueue.main.async {
                    self.activityindicatorcontainer.isHidden = true
                }


            }
            task.resume()
            
        } catch {
            print("error")
        }
        
        
        
    }

    
    
}
